
  --vista de la tabla sno_personal
CREATE OR REPLACE VIEW view_sno_personal AS 
 SELECT l_database_a.codper, 
    l_database_a.cedper, 
    l_database_a.nomper, 
    l_database_a.apeper, 
    (l_database_a.nomper::text || '</br>'::text) || l_database_a.apeper::text AS nombre_apellido, 
    l_database_a.dirper
   FROM dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 'select codper, cedper, nomper, apeper, dirper  from sno_personal'::text) l_database_a(codper character varying, cedper character varying, nomper character varying, apeper character varying, dirper character varying);

ALTER TABLE view_sno_personal
  OWNER TO postgres;
---
DROP VIEW documentos_pendientes;
select * from documentos_pendientes

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
    est.estatus AS accion_pendiente,
    solicitud.id,
    v_personal.nombre_apellido 
   FROM solicitud_documento sd
   JOIN flujos ON flujos.id = sd.id_flujos
   JOIN flujos f ON f.paso = (flujos.paso + 1) AND f.tipo_flujo = flujos.tipo_flujo AND f.id_documento = flujos.id_documento
   JOIN solicitud ON solicitud.id = sd.id_solicitud
   JOIN view_sno_personal as v_personal on v_personal.cedper=solicitud.cedula
   JOIN documento ON documento.id = sd.id_documento
   JOIN estatus ON estatus.id = flujos.id_estatus
   JOIN estatus est ON est.id = f.id_estatus
   LEFT JOIN flujos flu ON flu.paso = (flujos.paso + 2) AND flu.tipo_flujo = flujos.tipo_flujo AND flu.id_documento = flujos.id_documento
   LEFT JOIN asignar_procedimiento ap ON ap.id_procedimiento = sd.id;


-- DROP VIEW pendientes_general;

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
        END AS vencidos
   FROM documentos_pendientes dp
   JOIN documento ON documento.id = dp.id_documento
   LEFT JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 'select nomper, apeper, cedper from sno_personal'::text) l_database_a(nomper character varying, apeper character varying, cedper character varying) ON dp.cedula_rrhh::text = l_database_a.cedper::text;

ALTER TABLE pendientes_general
  OWNER TO postgres;
--añadir campo para guardar las nóminas
alter table solicit_datos
add nominas text;
--actualizando la vista de transferir procedimientos
--primero la borro
drop VIEW proc_trans;
--ahora la creo
CREATE OR REPLACE VIEW proc_trans AS 
 SELECT ap.id_procedimiento,
    ap.cedula,  
    case when ap.cedula='12345678' then 'PASANTE'
  ELSE v_personal.nomper END as nombre, 
    ap.id_procedimiento AS id_proc,
    CASE
            WHEN documento.id = 2 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_const_trab.nombre
               FROM t_const_trab
          JOIN solicitud_t_const_trab ON t_const_trab.id = solicitud_t_const_trab.id_t_const_trab
         WHERE solicitud_t_const_trab.id_solicitud = sd.id_solicitud))::text))::character varying
            WHEN documento.id = 7 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_copia.nombre
               FROM t_copia
          JOIN solicitud_t_copia ON t_copia.id = solicitud_t_copia.id_t_copia
         WHERE solicitud_t_copia.id_solicitud = sd.id_solicitud))::text))::character varying
            WHEN documento.id = 4 THEN ((documento.nombre::text || '-'::text) || ((( SELECT t_const_jub.nombre
               FROM t_const_jub
          JOIN solicitud_t_const_jub ON t_const_jub.id = solicitud_t_const_jub.id_t_const_jub
         WHERE solicitud_t_const_jub.id_solicitud = sd.id_solicitud))::text))::character varying
            ELSE documento.nombre
        END AS nombre_doc
   FROM asignar_procedimiento ap
   left JOIN view_sno_personal as v_personal on v_personal.cedper=ap.cedula
   inner join solicitud_documento as sd on sd.id=ap.id_procedimiento
   inner join documento on documento.id=sd.id_documento
  WHERE ap.terminado = 0 order by id_procedimiento;
  --actualizando los plazos
  update documento set plazo=5 where id=10 or id=8 or id=9 or id=1 or id=3;
update documento set plazo=5 where id=11 or id=4 or id=2;
  --actualizar los procedimientos que tienen como ultimo estatus el "Entregar Procedimiento"
--función para actualizar solicitud_documento y colocarle el último flujo
CREATE OR REPLACE FUNCTION act_solicitud_documento()
  RETURNS integer AS
$BODY$
declare 

_cont integer=0;
r record; 
begin

for r in (
select sd.id, sd.id_documento, sd.id_flujos, flujos.id_estatus, flujos.paso, flujos.descar, estatus.estatus, flu.paso as paso_penultimo, est.estatus, flu.id as id_actualizar
from solicitud_documento as sd
inner join flujos on flujos.id=sd.id_flujos
inner join estatus on flujos.id_estatus=estatus.id
inner join flujos as flu on flu.id_documento=sd.id_documento and flu.paso=flujos.paso-1
inner join estatus as est on est.id=flu.id_estatus
where estatus.estatus='ENTREGAR DOCUMENTO')
loop
  update solicitud_documento set id_flujos=r.id_actualizar where id=r.id;
  _cont=_cont + 1;
end loop;
  return _cont;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION act_solicitud_documento()
  OWNER TO postgres;
  --ejecuto la función
  select act_solicitud_documento();
  --eliminar los registros del historial donde los procedimientos tuvieron "ENTREGAR DOCUMENTO"

CREATE OR REPLACE FUNCTION elim_procedimiento_estatus()
  RETURNS integer AS
$BODY$
declare 

_cont integer=0;
r record; 
begin

for r in (
select pe.id, pe.id_estatus, pe.id_procedimiento, pe.paso, pe.tipo_flujo, estatus.estatus
from procedimiento_estatus as pe
inner join estatus on estatus.id=pe.id_estatus
where estatus='ENTREGAR DOCUMENTO')
loop
  DELETE FROM procedimiento_estatus WHERE id_procedimiento = r.id_procedimiento and id_estatus=r.id_estatus;
  _cont=_cont + 1;
end loop;
  return _cont;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION elim_procedimiento_estatus()
  OWNER TO postgres;
  --ejecuto la función
  select elim_procedimiento_estatus();
  --eliminar de la tabla de flujos el flujo con el último paso "ENTREGAR DOCUMENTO"
select * 
from flujos
inner join estatus on estatus.id=flujos.id_estatus
where estatus='ENTREGAR DOCUMENTO'


CREATE OR REPLACE FUNCTION elim_flujos()
  RETURNS integer AS
$BODY$
declare 

_cont integer=0;
r record; 
begin

for r in (
select * 
from flujos
inner join estatus on estatus.id=flujos.id_estatus
where estatus='ENTREGAR DOCUMENTO')
loop
  DELETE FROM flujos WHERE id = r.id;
  _cont=_cont + 1;
end loop;
  return _cont;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION elim_flujos()
  OWNER TO postgres;
  --ejecuto la función
  select elim_flujos();
  --eliminó el estatus
  delete from estatus where estatus='ENTREGAR DOCUMENTO';
--ACTUALIZACION de la vista para ver solo las nominas que me interesan
CREATE OR REPLACE VIEW nominas_org AS 
 SELECT DISTINCT sno_dt_spg.codnom, 
    substr_nomina(sno_dt_spg.descripcion) AS descripcion
   FROM sno_dt_spg
   where (substr_nomina(sno_dt_spg.descripcion) NOT like '%APORTES%') AND 
   ((codnom::integer between 1 and 5) or (codnom::integer between 8 and 10) or (codnom::integer between 12 and  16) or (codnom::integer between 18 and 19) or
   (codnom::integer between 23 and 32) or (codnom::integer between 44 and 49))
  ORDER BY sno_dt_spg.codnom;

  --actualizacion de vista pendientes_generalCREATE OR REPLACE VIEW consulta_general_solicitudes AS 
 SELECT solicitud.id, 
    solicitud.id AS codigo, 
    solicitud.cedula, 
    (l_database_a.nomper::text || ' '::text) || l_database_a.apeper::text AS nombre_apellido, 
    solicitud.fecha_solicitud, 
    l_database_a.dirper, 
    solicitud.observacion, 
    proc_x_solicitud(solicitud.id) AS procedimientos,
    sod.nominas
   FROM solicitud
   JOIN view_sno_personal as l_database_a on l_database_a.cedper=solicitud.cedula
   inner join solicit_datos as sod on sod.cedula::text=solicitud.cedula 
  ORDER BY solicitud.id;

ALTER TABLE consulta_general_solicitudes
  OWNER TO postgres;

  --actualizacion de vista
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
    sd.id AS id_sd,
    sod.nominas
   FROM solicitud_documento sd
   JOIN documento doc ON doc.id = sd.id_documento
   JOIN solicitud ON solicitud.id = sd.id_solicitud
   JOIN flujos ON flujos.id = sd.id_flujos
   JOIN estatus ON estatus.id = flujos.id_estatus
   JOIN solicit_datos sod ON sod.cedula::text = solicitud.cedula::text;

   --vista para ser ejecutada en database_a
   create or replace view view_solicit_datos as
select * from dblink('dbname=sicaf port=5432 host=localhost user=postgres password=postgres'::text, 'select cedula, tlf_habitacion, tlf_celular, correo from solicit_datos'::text) 
l_sicaf (cedula integer, tlf_habitacion character varying, tlf_celular character varying, correo character varying);

--actualizacion de vista
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
    est.estatus AS accion_pendiente, 
    solicitud.id, 
    v_personal.nombre_apellido,
    sod.nominas
   FROM solicitud_documento sd
   JOIN flujos ON flujos.id = sd.id_flujos
   JOIN flujos f ON f.paso = (flujos.paso + 1) AND f.tipo_flujo = flujos.tipo_flujo AND f.id_documento = flujos.id_documento
   JOIN solicitud ON solicitud.id = sd.id_solicitud
   JOIN view_sno_personal v_personal ON v_personal.cedper::text = solicitud.cedula::text
   JOIN documento ON documento.id = sd.id_documento
   JOIN estatus ON estatus.id = flujos.id_estatus
   JOIN estatus est ON est.id = f.id_estatus
   JOIN solicit_datos sod ON sod.cedula::text = solicitud.cedula::text
   LEFT JOIN flujos flu ON flu.paso = (flujos.paso + 2) AND flu.tipo_flujo = flujos.tipo_flujo AND flu.id_documento = flujos.id_documento
   LEFT JOIN asignar_procedimiento ap ON ap.id_procedimiento = sd.id;
   --actualizacion de la vista
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
    sd.id AS id_sd,
    sod.nominas
   FROM solicitud_documento sd
   JOIN documento doc ON doc.id = sd.id_documento
   JOIN solicitud ON solicitud.id = sd.id_solicitud
   JOIN flujos ON flujos.id = sd.id_flujos
   JOIN estatus ON estatus.id = flujos.id_estatus
   JOIN solicit_datos sod ON sod.cedula::text = solicitud.cedula::text;
   --actualizacion de vista
   
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
        sod.nominas,
        solicitud.cedula
   FROM documentos_pendientes dp
   JOIN documento ON documento.id = dp.id_documento
   join solicitud on solicitud.id=dp.id
   JOIN solicit_datos sod ON sod.cedula::text = solicitud.cedula::text
   LEFT JOIN view_sno_personal as l_database_a on l_database_a.cedper=dp.cedula_rrhh;