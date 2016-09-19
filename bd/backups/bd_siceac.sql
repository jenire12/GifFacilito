


CREATE TABLE "tsca_mtcargo" (
"id_cargo"  SERIAL NOT NULL ,
"descripcion" VARCHAR(150) NOT NULL ,
PRIMARY KEY ("id_cargo")
);

CREATE TABLE "tsca_lesiones" (
" cod_lesion" VARCHAR(10) NOT NULL ,
"descripcion" VARCHAR(200) NOT NULL ,
PRIMARY KEY (" cod_lesion")
);

CREATE TABLE "tsca_accidente" (
"id_reporte"  SERIAL NOT NULL ,
"fec_registro" TIMESTAMP WITHOUT TIME ZONE NOT NULL ,
"fec_informe" DATE NOT NULL ,
"jefe_turno" VARCHAR(10) NOT NULL ,
"fec_ocurrencia" DATE NOT NULL ,
"turno" INTEGER NOT NULL ,
"trabajador_lesionado" VARCHAR(10) NOT NULL ,
"profesion_oficio" VARCHAR(150) NOT NULL ,
"lesion" VARCHAR(10) NOT NULL ,
"descripcion_accidente" TEXT NOT NULL ,
"recomendaciones" TEXT ,
"perdida_tiempo" CHAR(2) NOT NULL ,
"sobretiempo" CHAR(2) NOT NULL ,
"cuadrillas" SERIAL ,
PRIMARY KEY ("id_reporte")
);

CREATE TABLE "tsca_mttrabajador" (
"id_ficha" VARCHAR(10) NOT NULL ,
"cedula" VARCHAR(9) NOT NULL ,
"nombres" VARCHAR(100) NOT NULL ,
"apellidos" VARCHAR(100) NOT NULL ,
"cargo" INTEGER ,
"fec_ingreso" DATE NOT NULL ,
"departamento" INTEGER NOT NULL ,
"fec_nacimiento" DATE ,
"sexo" CHAR(1) ,
"cuadrilla" INTEGER NOT NULL ,
PRIMARY KEY ("id_ficha"),
UNIQUE ("cedula")
);

CREATE TABLE "tsca_departamentos" (
"cod_departamento" SERIAL NOT NULL ,
"descripcion" VARCHAR(150) NOT NULL ,
"nivel" INTEGER NOT NULL /* Nivel: Campo que define el nivel en el cual se encuentra el Dpto. (1 -2-3 4 ...) */,
"dpto_padre" INTEGER ,
PRIMARY KEY ("cod_departamento")
);
COMMENT ON COLUMN "tsca_departamentos"."nivel" IS 'Nivel: Campo que define el nivel en el cual se encuentra el Dpto. (1 -2-3 4 ...)';

CREATE TABLE "tsca_asistenciamedica" (
"id_reporte" BIGINT NOT NULL ,
"id_ficha" VARCHAR(10) NOT NULL ,
PRIMARY KEY ("id_reporte", "id_ficha")
);
COMMENT ON TABLE "tsca_asistenciamedica" IS 'Tabla que representa relación del personal que atendió al lesionado en un determinado accidente';

CREATE TABLE "tsca_usuarios" (
"login" VARCHAR(9) NOT NULL ,
"passwd" TEXT NOT NULL ,
"nivel" INTEGER NOT NULL ,
PRIMARY KEY ("login")
);

CREATE TABLE "tsca_turnos" (
"id_turno"  SERIAL NOT NULL ,
"descripcion" VARCHAR(20) NOT NULL ,
PRIMARY KEY ("id_turno")
);

CREATE TABLE "tsca_cuadrillas" (
"cod_cuadrillas" SERIAL NOT NULL ,
"descripcion" VARCHAR NOT NULL ,
PRIMARY KEY ("cod_cuadrillas")
);

ALTER TABLE "tsca_accidente" ADD FOREIGN KEY ("jefe_turno") REFERENCES "tsca_mttrabajador" ("id_ficha");
ALTER TABLE "tsca_accidente" ADD FOREIGN KEY ("turno") REFERENCES "tsca_turnos" ("id_turno");
ALTER TABLE "tsca_accidente" ADD FOREIGN KEY ("trabajador_lesionado") REFERENCES "tsca_mttrabajador" ("id_ficha");
ALTER TABLE "tsca_accidente" ADD FOREIGN KEY ("lesion") REFERENCES "tsca_lesiones" (" cod_lesion");
ALTER TABLE "tsca_mttrabajador" ADD FOREIGN KEY ("cedula") REFERENCES "tsca_usuarios" ("login");
ALTER TABLE "tsca_mttrabajador" ADD FOREIGN KEY ("cargo") REFERENCES "tsca_mtcargo" ("id_cargo");
ALTER TABLE "tsca_mttrabajador" ADD FOREIGN KEY ("departamento") REFERENCES "tsca_departamentos" ("cod_departamento");
ALTER TABLE "tsca_mttrabajador" ADD FOREIGN KEY ("cuadrilla") REFERENCES "tsca_cuadrillas" ("cod_cuadrillas");
ALTER TABLE "tsca_departamentos" ADD FOREIGN KEY ("dpto_padre") REFERENCES "tsca_departamentos" ("cod_departamento");
ALTER TABLE "tsca_asistenciamedica" ADD FOREIGN KEY ("id_reporte") REFERENCES "tsca_accidente" ("id_reporte");
ALTER TABLE "tsca_asistenciamedica" ADD FOREIGN KEY ("id_ficha") REFERENCES "tsca_mttrabajador" ("id_ficha");

