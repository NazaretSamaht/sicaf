alter table solicitud_documento
add cant_proc integer;

--actualización de la función para mostrar los procedimientos por solicitud
CREATE OR REPLACE FUNCTION proc_x_solicitud(_id_solicitud integer)
  RETURNS character varying AS
$BODY$
declare 
_procedimientos text= '';
r record; 
begin

for r in (select sd.id_solicitud, 'Cant.:'||sd.cant_proc ||', '|| doc.nombre as procedimientos
	from solicitud_documento as sd 
	inner join documento as doc on doc.id=sd.id_documento
	where sd.id_solicitud=_id_solicitud
	group by sd.id_solicitud, sd.id_documento, doc.nombre, sd.cant_proc 
	order by sd.id_solicitud)
loop
	if(_procedimientos='') then
		_procedimientos=r.procedimientos;
	else
		_procedimientos=_procedimientos||'</br>'||r.procedimientos;
	end if;
	
end loop;
	return _procedimientos;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION proc_x_solicitud(integer)
  OWNER TO postgres;


--actualización de la vista con las solicitudes en general

CREATE OR REPLACE VIEW consulta_general_solicitudes AS 


 SELECT solicitud.id, 
    solicitud.id AS codigo, 
    solicitud.cedula, 
    (l_database_a.nomper::text || ' '::text) || l_database_a.apeper::text AS nombre_apellido, 
    solicitud.fecha_solicitud, 
    l_database_a.dirper, 
    solicitud.observacion, 
    proc_x_solicitud(solicitud.id) AS procedimientos
   FROM solicitud
   JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 'select nomper, apeper, cedper, dirper from sno_personal'::text) l_database_a(nomper character varying, apeper character varying, cedper character varying, dirper character varying) ON solicitud.cedula::text = l_database_a.cedper::text
  ORDER BY solicitud.id;

ALTER TABLE consulta_general_solicitudes
  OWNER TO postgres;

--elimino la siguiente vista para actualizarla
drop view consulta_solicitud_documentos;
-- la actualizo
CREATE OR REPLACE VIEW consulta_solicitud_documentos AS 
 SELECT solicitud_documento.id_solicitud, 
    solicitud_documento.id AS id_procedimiento, 
    t_documento.nombre AS tipo, 
    documento.id, 
        CASE
            WHEN documento.id = 2 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_const_trab.nombre
               FROM t_const_trab
          JOIN solicitud_t_const_trab ON t_const_trab.id = solicitud_t_const_trab.id_t_const_trab
         WHERE solicitud_t_const_trab.id_solicitud = solicitud_documento.id_solicitud))::text))::character varying
            WHEN documento.id = 7 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_copia.nombre
               FROM t_copia
          JOIN solicitud_t_copia ON t_copia.id = solicitud_t_copia.id_t_copia
         WHERE solicitud_t_copia.id_solicitud = solicitud_documento.id_solicitud))::text))::character varying
            WHEN documento.id = 4 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_const_jub.nombre
               FROM t_const_jub
          JOIN solicitud_t_const_jub ON t_const_jub.id = solicitud_t_const_jub.id_t_const_jub
         WHERE solicitud_t_const_jub.id_solicitud = solicitud_documento.id_solicitud))::text))::character varying
            ELSE documento.nombre
        END AS nombre_doc,
    cant_proc, 
    recaudos(documento.id) AS recaudos, 
    documento.plazo, 
    estatus.estatus
   FROM t_documento
   JOIN documento ON documento.id_t_documento = t_documento.id
   JOIN solicitud_documento ON solicitud_documento.id_documento = documento.id
   JOIN flujos ON flujos.id = solicitud_documento.id_flujos
   JOIN estatus ON flujos.id_estatus = estatus.id
  ORDER BY t_documento.id, documento.id;

ALTER TABLE consulta_solicitud_documentos
  OWNER TO postgres;

  --elimino la vista
  drop view procedimientos_todos
  --la actualizo


CREATE OR REPLACE VIEW procedimientos_todos AS 
SELECT sd.id_solicitud, 
    sd.id, 
    solicitud.cedula, 
    doc.nombre,
    sd.cant_proc, 
    solicitud.fecha_solicitud, 
    estatus.estatus, 
        CASE
            WHEN doc.tipo_unidad::text = 'c'::text THEN ( SELECT coordinacion.coordinacion
               FROM coordinacion
              WHERE coordinacion.id = doc.id_unidad)
            ELSE NULL::character varying
        END AS unidad, 
    sd.id AS id_sd
   FROM solicitud_documento sd
   JOIN documento doc ON doc.id = sd.id_documento
   JOIN solicitud ON solicitud.id = sd.id_solicitud
   JOIN flujos ON flujos.id = sd.id_flujos
   JOIN estatus ON estatus.id = flujos.id_estatus;

ALTER TABLE procedimientos_todos
  OWNER TO postgres;




--elimino las vistas
drop view pendientes_general;
drop view documentos_pendientes;
--creo las vistas
-- View: documentos_pendientes

-- DROP VIEW documentos_pendientes;

CREATE OR REPLACE VIEW documentos_pendientes AS 
 SELECT sd.id AS id_sd, 
    sd.id_documento, 
    sd.terminado, 
    sd.id_flujos, 
    flujos.id_estatus, 
    flujos.paso, 
    flujos.descar, 
    f.paso AS paso_proximo, 
    f.descar AS descar_actual, 
        CASE
            WHEN documento.id = 2 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_const_trab.nombre
               FROM t_const_trab
          JOIN solicitud_t_const_trab ON t_const_trab.id = solicitud_t_const_trab.id_t_const_trab
         WHERE solicitud_t_const_trab.id_solicitud = sd.id_solicitud))::text))::character varying
            WHEN documento.id = 4 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_const_jub.nombre
               FROM t_const_jub
          JOIN solicitud_t_const_jub ON t_const_jub.id = solicitud_t_const_jub.id_t_const_jub
         WHERE solicitud_t_const_jub.id_solicitud = sd.id_solicitud))::text))::character varying
            ELSE documento.nombre
        END AS procedimiento, 
    solicitud.cedula, 
    estatus.estatus, 
    (((f.id_estatus || '_'::text) || f.paso) || '_'::text) || flujos.tipo_flujo AS id_proximo, 
    solicitud.fecha_solicitud, 
    ap.id_procedimiento,
    sd.cant_proc, 
    ap.cedula AS cedula_rrhh, 
    flu.descar AS descar_proximo, 
    est.estatus AS accion_pendiente
   FROM solicitud_documento sd
   JOIN flujos ON flujos.id = sd.id_flujos
   JOIN flujos f ON f.paso = (flujos.paso + 1) AND f.tipo_flujo = flujos.tipo_flujo AND f.id_documento = flujos.id_documento
   JOIN solicitud ON solicitud.id = sd.id_solicitud
   JOIN documento ON documento.id = sd.id_documento
   JOIN estatus ON estatus.id = flujos.id_estatus
   JOIN estatus est ON est.id = f.id_estatus
   LEFT JOIN flujos flu ON flu.paso = (flujos.paso + 2) AND flu.tipo_flujo = flujos.tipo_flujo AND flu.id_documento = flujos.id_documento
   LEFT JOIN asignar_procedimiento ap ON ap.id_procedimiento = sd.id;
ALTER TABLE documentos_pendientes
  OWNER TO postgres;
--ahora la otra

CREATE OR REPLACE VIEW pendientes_general AS 
 SELECT dp.id_sd, 
    documento.nombre, 
    documento.plazo, 
    dp.fecha_solicitud, 
        CASE
            WHEN dp.descar_actual::text = 'ANALISTA'::text THEN (l_database_a.nomper::text || ' '::text) || l_database_a.apeper::text
            WHEN dp.descar_actual::text = 'ARCHIVISTA'::text THEN (( SELECT responsables('ARCHIVISTA III'::character varying) AS responsables))::text
            WHEN dp.descar_actual::text = 'JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI'::text THEN (( SELECT responsables('JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI'::character varying) AS responsables))::text
            WHEN dp.descar_actual::text = 'DIRECTOR'::text THEN (( SELECT responsables('DIRECTOR'::character varying) AS responsables))::text
            WHEN dp.descar_actual::text = 'AGENTE DE ATENCION INTEGRAL'::text THEN (( SELECT responsables('AGENTE DE ATENCION INTEGRAL'::character varying) AS responsables))::text
            ELSE NULL::text
        END AS responsable, 
    dp.accion_pendiente, 
    dp.fecha_solicitud + documento.plazo AS fecha_vencimiento, 
        CASE
            WHEN 'now'::text::date > (dp.fecha_solicitud + documento.plazo) AND dp.accion_pendiente::text <> 'ENTREGAR DOCUMENTO'::text THEN 'VENCIDO'::text
            WHEN dp.accion_pendiente::text = 'ENTREGAR DOCUMENTO'::text THEN 'LISTO PARA ENTREGAR'::text
            WHEN 'now'::text::date = (dp.fecha_solicitud + documento.plazo) AND dp.accion_pendiente::text <> 'ENTREGAR DOCUMENTO'::text THEN 'PROXIMO A VENCER'::text
            ELSE 'A TIEMPO'::text
        END AS estatus, 
        CASE
            WHEN 'now'::text::date > (dp.fecha_solicitud + documento.plazo) AND dp.accion_pendiente::text <> 'ENTREGAR DOCUMENTO'::text THEN 'now'::text::date - (dp.fecha_solicitud + documento.plazo)
            ELSE 0
        END AS vencidos,
   FROM documentos_pendientes dp
   JOIN documento ON documento.id = dp.id_documento
   LEFT JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 'select nomper, apeper, cedper from sno_personal'::text) l_database_a(nomper character varying, apeper character varying, cedper character varying) ON dp.cedula_rrhh::text = l_database_a.cedper::text;

ALTER TABLE pendientes_general
  OWNER TO postgres;
--tabla de correspondencias
create table correspondencia(
	id serial not null,
	correspondencia character varying(200),
	creado timestamp without time zone DEFAULT now(),
	modificado timestamp without time zone DEFAULT now(),
	CONSTRAINT correspondencia_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE correspondencia
  OWNER TO postgres;

-- Trigger: update_modified on direccion

-- DROP TRIGGER update_modified ON direccion;

CREATE TRIGGER update_modified
  BEFORE UPDATE
  ON correspondencia
  FOR EACH ROW
  EXECUTE PROCEDURE set_modified();

  