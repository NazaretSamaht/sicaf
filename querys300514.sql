alter table usuarios
	add cargo character varying;

--correr por separado
alter table usuarios
	drop column tlf_local, tlf_celular, correo;
--para crear los campos de modificado y creado
--primero
  CREATE OR REPLACE FUNCTION set_modified()
			  RETURNS trigger AS $BODY$ 
			  BEGIN 
				NEW.modificado = now();
				RETURN NEW; 
			  END; $BODY$
			  LANGUAGE plpgsql VOLATILE STRICT
			  COST 100;
			ALTER FUNCTION set_modified() OWNER TO postgres;
-- DROP FUNCTION set_create_modified(text[]);
--segundo
CREATE OR REPLACE FUNCTION set_create_modified(text[])
  RETURNS int AS
$BODY$ 	
DECLARE
	_SCHEMES ALIAS FOR $1;
	_RECORD record;
	_SET_MOFIDIED character varying = 'set_modified';
	_CREATED character varying = 'creado';
	_MODIFIED character varying = 'modificado';
	_SQL text;
	_I integer = 0;
BEGIN

	IF (_SCHEMES ISNULL) THEN _SCHEMES = '{public}'::text[]; END IF;

	PERFORM routine_name FROM information_schema.routines WHERE specific_schema = 'public' AND routine_name = _SET_MOFIDIED;

	IF (NOT FOUND) THEN

		_SQL = 'CREATE OR REPLACE FUNCTION ' || _SET_MOFIDIED || '()
			  RETURNS trigger AS '' 
			  BEGIN 
				NEW.' || _MODIFIED || ' = now();
				RETURN NEW; 
			  END; ''
			  LANGUAGE plpgsql VOLATILE STRICT
			  COST 100;
			ALTER FUNCTION ' || _SET_MOFIDIED || '() OWNER TO postgres';
			
		RAISE NOTICE '_SQL: %', _SQL;
		EXECUTE _SQL;
	END IF; 


	FOR _RECORD IN 
		SELECT * FROM (
			SELECT columns.table_schema, columns.table_name, 
			SUM(CASE WHEN columns.column_name = _CREATED THEN 1 ELSE 0 END) AS created,
			SUM(CASE WHEN columns.column_name = _MODIFIED THEN 1 ELSE 0 END) AS modified
			FROM information_schema.columns 
			INNER JOIN information_schema.tables ON tables.table_schema = columns.table_schema AND tables.table_name = columns.table_name
			WHERE columns.table_schema = ANY (_SCHEMES) AND tables.table_type = 'BASE TABLE'
			GROUP BY columns.table_schema, columns.table_name
		) AS t
		WHERE created + modified < 2
	LOOP
		_I = _I + 1;

		IF (_RECORD.created = 0) THEN
			_SQL = 'ALTER TABLE ' || _RECORD.table_schema || '.' || _RECORD.table_name || ' ADD ' || _CREATED || ' timestamp without time zone DEFAULT now()';
			RAISE NOTICE '_SQL: %', _SQL;
			EXECUTE _SQL;
		END IF;

		IF (_RECORD.modified = 0) THEN
			_SQL = 'ALTER TABLE ' || _RECORD.table_schema || '.' || _RECORD.table_name || ' ADD ' || _MODIFIED || ' timestamp without time zone DEFAULT now()';
			RAISE NOTICE '_SQL: %', _SQL;
			EXECUTE _SQL;
		END IF;

		_SQL = 'CREATE TRIGGER update_modified
			BEFORE UPDATE
			ON ' || _RECORD.table_schema || '.' || _RECORD.table_name || ' 
			FOR EACH ROW
			EXECUTE PROCEDURE ' || _SET_MOFIDIED || '()';

		RAISE NOTICE '_SQL: %', _SQL;
		EXECUTE _SQL;
		
	END LOOP;		


	

	RETURN _I;
END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION set_create_modified(text[])
  OWNER TO postgres;



--tercero
select set_create_modified (null);

--creo el trigger de cargos
  CREATE OR REPLACE FUNCTION seleccionar_cargo()
  RETURNS trigger AS $BODY$ 
  declare

  BEGIN 
	select into NEW.cargo l_database_a.cargo
	from usuarios
	JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
	'select sno_personal.cedper, CASE WHEN sno_personalnomina.descasicar isnull THEN sno_cargo.descar ELSE sno_personalnomina.descasicar END as cargo
	 from sno_personal
	 inner join sno_personalnomina on sno_personal.codper=sno_personalnomina.codper
	 inner join sno_cargo ON sno_cargo.codemp=sno_personalnomina.codemp and sno_cargo.codnom=sno_personalnomina.codnom and sno_cargo.codcar=sno_personalnomina.codcar where cedper='''||NEW.cedula||''''::text) 
	 l_database_a (cedper integer, cargo character varying) ON usuarios.cedula::text = l_database_a.cedper::text limit 1;
	--raise notice '%,%',NEW, _x;
	RETURN NEW; 
  END; $BODY$
  LANGUAGE plpgsql VOLATILE STRICT
  COST 100;
ALTER FUNCTION seleccionar_cargo() OWNER TO postgres;

--creo el disparador
CREATE TRIGGER guardar_cargo
  BEFORE INSERT
  ON usuarios
  FOR EACH ROW
  EXECUTE PROCEDURE seleccionar_cargo();

  --función que al ejecutarse se actualizan los cargos que ya estan en la tabla de usuarios contra los cargos del sigesp
CREATE OR REPLACE FUNCTION actualizar_cargos()
  RETURNS integer AS
$BODY$
declare 
_cont integer;

r record; 
begin

for r in (select cedula from usuarios where status=1)
loop
	update usuarios set cargo= (select l_database_a.cargo
	from usuarios
	JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
	'select sno_personal.cedper, CASE WHEN sno_personalnomina.descasicar isnull THEN sno_cargo.descar ELSE sno_personalnomina.descasicar END as cargo
	 from sno_personal
	 inner join sno_personalnomina on sno_personal.codper=sno_personalnomina.codper
	 inner join sno_cargo ON sno_cargo.codemp=sno_personalnomina.codemp and sno_cargo.codnom=sno_personalnomina.codnom and sno_cargo.codcar=sno_personalnomina.codcar'::text) 
	 l_database_a (cedper integer, cargo character varying) ON usuarios.cedula::text = l_database_a.cedper::text where cedula=r.cedula limit 1) where cedula=r.cedula;
	 _cont=_cont + 1;
end loop;
	return _cont;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION actualizar_cargos()
  OWNER TO postgres;

--ejecuto la funcion para actualizar los cargos de la tabla de usuarios con los cargos del sigesp
select actualizar_cargos()

--vista con los procedimientos de todos
CREATE VIEW pendientes_general as
select id_sd, documento.nombre, documento.plazo, fecha_solicitud, l_database_a.nomper||' '||l_database_a.apeper as responsable, accion_pendiente, 
fecha_solicitud + documento.plazo as fecha_vencimiento,
case when CURRENT_DATE>=fecha_solicitud + documento.plazo and accion_pendiente!='ENTREGAR DOCUMENTO' then 'VENCIDO' 
     when accion_pendiente='ENTREGAR DOCUMENTO' then 'LISTO PARA ENTREGAR'
     when CURRENT_DATE>=fecha_solicitud + documento.plazo - 1 and accion_pendiente!='ENTREGAR DOCUMENTO' then 'PROXIMO A VENCER'
     else 'A TIEMPO' END AS estatus
from documentos_pendientes as dp
inner join documento on documento.id= dp.id_documento
left JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
'select nomper, apeper, cedper from sno_personal'::text) 
l_database_a(nomper character varying, apeper character varying, cedper character varying) ON dp.cedula_rrhh::text = l_database_a.cedper::text


--funcion para concatenar nombres de responsables en un solo campo, responsables de documentacion encargados del despacho del director

CREATE OR REPLACE FUNCTION responsables(character varying)
  RETURNS character varying AS
$BODY$
declare 
_cad alias for $1;
_nombres character varying (500)= '';
r record; 
begin
if ((_cad='ARCHIVISTA I') OR (_cad='ARCHIVISTA III')) then
	for r in (select cedula, l_database_a.nomper||' '||l_database_a.apeper as nombre_apellido 
		from usuarios 
		JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
		'select nomper, apeper, cedper from sno_personal'::text) 
		l_database_a(nomper character varying, apeper character varying, cedper character varying) ON cedula::text = l_database_a.cedper::text
		where cargo='ARCHIVISTA I' or cargo='ARCHIVISTA III')
	loop
		_nombres=_nombres||'</br>'||r.nombre_apellido;
	end loop;

elsif (_cad='JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI') then 
		--solo busca al jefe de division y coordinador de documentacion
	for r in (select usuarios.cedula, l_database_a.nomper||' '||l_database_a.apeper as nombre_apellido 
		from usuarios 
		JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
		'select nomper, apeper, cedper from sno_personal'::text) 
		l_database_a(nomper character varying, apeper character varying, cedper character varying) ON cedula::text = l_database_a.cedper::text
		inner join recursos_usuarios as ru on ru.cedula=usuarios.cedula
		where (cargo='JEFE DE DIVISION'  and tipo_unidad='d' and id_unidad=1) or (cargo='JEFE TECNICO ADMINISTRATIVO VI' and tipo_unidad='c' and id_unidad=2))

	loop
		_nombres=_nombres||'</br>'||r.nombre_apellido;
	end loop;
elsif (_cad='DIRECTOR') then 
		--solo busca a los responsables del despacho del director con respecto al sicaf
	for r in (select usuarios.cedula, l_database_a.nomper||' '||l_database_a.apeper as nombre_apellido 
		from usuarios 
		JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
		'select nomper, apeper, cedper from sno_personal'::text) 
		l_database_a(nomper character varying, apeper character varying, cedper character varying) ON cedula::text = l_database_a.cedper::text
		inner join recursos_usuarios as ru on ru.cedula=usuarios.cedula
		where cargo='DIRECTOR') 

	loop
		_nombres=_nombres||'</br>'||r.nombre_apellido;
	end loop;
elsif (_cad='AGENTE DE ATENCION INTEGRAL') then 
		--solo busca a los responsables de la taquilla
	for r in (select usuarios.cedula, l_database_a.nomper||' '||l_database_a.apeper as nombre_apellido 
		from usuarios 
		JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
		'select nomper, apeper, cedper from sno_personal'::text) 
		l_database_a(nomper character varying, apeper character varying, cedper character varying) ON cedula::text = l_database_a.cedper::text
		inner join recursos_usuarios as ru on ru.cedula=usuarios.cedula
		where (cargo='AGENTE DE ATENCION INTEGRAL') or (cargo='JEFE TECNICO ADMINISTRATIVO VI' and tipo_unidad='c' and id_unidad='16'))
	loop
		_nombres=_nombres||'</br>'||r.nombre_apellido;
	end loop;
END IF;
	return _nombres;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION responsables(character varying)
  OWNER TO postgres;


  --vista que me genera todos los pendientes
 CREATE VIEW pendientes_general as
select id_sd, documento.nombre, documento.plazo, fecha_solicitud, 
case when descar_actual='ANALISTA' then l_database_a.nomper||' '||l_database_a.apeper
     when descar_actual='ARCHIVISTA' then (select responsables('ARCHIVISTA III'))
     when descar_actual='JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI' then (select responsables('JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI'))
     when descar_actual='DIRECTOR' then (select responsables('DIRECTOR'))
     when descar_actual='AGENTE DE ATENCION INTEGRAL' then (select responsables('AGENTE DE ATENCION INTEGRAL'))
end as responsable,
accion_pendiente, 
fecha_solicitud + documento.plazo as fecha_vencimiento,
case when CURRENT_DATE>fecha_solicitud + documento.plazo and accion_pendiente!='ENTREGAR DOCUMENTO' then 'VENCIDO' 
     when accion_pendiente='ENTREGAR DOCUMENTO' then 'LISTO PARA ENTREGAR'
     when CURRENT_DATE=fecha_solicitud + documento.plazo and accion_pendiente!='ENTREGAR DOCUMENTO' then 'PROXIMO A VENCER'
     else 'A TIEMPO' END AS estatus,
case when CURRENT_DATE>fecha_solicitud + documento.plazo and accion_pendiente!='ENTREGAR DOCUMENTO' THEN CURRENT_DATE-(fecha_solicitud + documento.plazo)
ELSE 0 END AS vencidos
from documentos_pendientes as dp
inner join documento on documento.id= dp.id_documento
left JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
'select nomper, apeper, cedper from sno_personal'::text) 
l_database_a(nomper character varying, apeper character varying, cedper character varying) ON dp.cedula_rrhh::text = l_database_a.cedper::text

 --SELECT * FROM documentos_pendientes


select id_sd, descar_actual, accion_pendiente,
case when descar_actual='ANALISTA' then l_database_a.nomper||' '||l_database_a.apeper
     when descar_actual='ARCHIVISTA' then (select responsables('ARCHIVISTA III'))
     when descar_actual='JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI' then (select responsables('JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI'))
     when descar_actual='DIRECTOR' then (select responsables('DIRECTOR'))
     when descar_actual='AGENTE DE ATENCION INTEGRAL' then (select responsables('AGENTE DE ATENCION INTEGRAL'))
end as responsable
from documentos_pendientes as dp

left JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
'select nomper, apeper, cedper from sno_personal'::text) 
l_database_a(nomper character varying, apeper character varying, cedper character varying) ON dp.cedula_rrhh::text = l_database_a.cedper::text;