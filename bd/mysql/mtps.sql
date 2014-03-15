/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50532
Source Host           : 127.0.0.1:3306
Source Database       : mtps

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2014-03-11 08:34:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for org_almacen
-- ----------------------------
DROP TABLE IF EXISTS `org_almacen`;
CREATE TABLE `org_almacen` (
  `id_almacen` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_almacen` varchar(100) DEFAULT NULL,
  `id_guarda` int(10) DEFAULT NULL,
  `id_actualiza` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_almacen`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_almacen
-- ----------------------------
INSERT INTO `org_almacen` VALUES ('1', 'EDIFICIO 2 NIVEL 1', '0', null);
INSERT INTO `org_almacen` VALUES ('2', 'EDIFICIO 2 NIVEL 2', null, null);
INSERT INTO `org_almacen` VALUES ('3', 'EDIFICIO 3 NIVEL 1', null, null);
INSERT INTO `org_almacen` VALUES ('4', 'EDIFICIO 3 NIVEL 2', null, null);
INSERT INTO `org_almacen` VALUES ('5', 'EDIFICIO 4 NIVEL 1', null, null);
INSERT INTO `org_almacen` VALUES ('6', 'EDIFICIO 4 NIVEL 2', null, null);
INSERT INTO `org_almacen` VALUES ('7', 'EDIFICIO 5', null, null);
INSERT INTO `org_almacen` VALUES ('8', 'ANEXO CLINICA', null, null);
INSERT INTO `org_almacen` VALUES ('9', 'ANEXO CAFETERIA', null, null);
INSERT INTO `org_almacen` VALUES ('10', 'OFICINA DEPARTAMENTAL DE SANTA ANA', null, null);
INSERT INTO `org_almacen` VALUES ('11', 'OFICINA DEPARTAMENTAL DE SONSONATE', null, null);
INSERT INTO `org_almacen` VALUES ('12', 'OFICINA DEPARTAMENTAL DE AHUACHAPAN', null, null);
INSERT INTO `org_almacen` VALUES ('13', 'OFICINA DEPARTAMENTAL DE CHALATENANGO', null, null);
INSERT INTO `org_almacen` VALUES ('14', 'OFICINA DEPARTAMENTAL DE CABAÑAS', null, null);
INSERT INTO `org_almacen` VALUES ('15', 'OFICINA DEPARTAMENTAL DE LA LIBERTAD', null, null);
INSERT INTO `org_almacen` VALUES ('16', 'OFICINA DEPARTAMENTAL DE CUSCATLAN', null, null);
INSERT INTO `org_almacen` VALUES ('17', 'OFICINA DEPARTAMENTAL DE SAN VICENTE', null, null);
INSERT INTO `org_almacen` VALUES ('18', 'OFICINA DEPARTAMENTAL DE ZACATECOLUCA', null, null);
INSERT INTO `org_almacen` VALUES ('19', 'OFICINA DEPARTAMENTAL DE USULUTAN', null, null);
INSERT INTO `org_almacen` VALUES ('20', 'OFICINA DEPARTAMENTAL DE SAN MIGUEL', null, null);
INSERT INTO `org_almacen` VALUES ('21', 'OFICINA DEPARTAMENTAL DE MORAZÁN', null, null);
INSERT INTO `org_almacen` VALUES ('22', 'OFICINA DEPARTAMENTAL DE LA UNIÓN', null, null);
INSERT INTO `org_almacen` VALUES ('23', 'ARCHIVO GENERAL', null, null);
INSERT INTO `org_almacen` VALUES ('24', 'ARCHIVO INSTITUCIONAL', null, null);
INSERT INTO `org_almacen` VALUES ('25', 'ANEXOS SERVICIOS GENERALES', null, null);
INSERT INTO `org_almacen` VALUES ('26', 'CENTRO OBRERO COATEPEQUE', null, null);
INSERT INTO `org_almacen` VALUES ('27', 'CENTRO OBRERO CONCHALIO', null, null);
INSERT INTO `org_almacen` VALUES ('28', 'CENTRO OBRERO EL TAMARINDO', null, null);
INSERT INTO `org_almacen` VALUES ('29', 'CENTRO OBRERO LA PALMA', null, null);
INSERT INTO `org_almacen` VALUES ('30', 'BOLSAS DE EMPLEO', null, null);
INSERT INTO `org_almacen` VALUES ('31', 'ANEXO INSPECCION', null, null);
INSERT INTO `org_almacen` VALUES ('32', 'ANEXO EDIFICACIONES', null, null);

-- ----------------------------
-- Table structure for org_departamento
-- ----------------------------
DROP TABLE IF EXISTS `org_departamento`;
CREATE TABLE `org_departamento` (
  `id_departamento` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `departamento` varchar(50) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_departamento
-- ----------------------------
INSERT INTO `org_departamento` VALUES ('00001', 'AHUACHAPÁN');
INSERT INTO `org_departamento` VALUES ('00002', 'SANTA ANA');
INSERT INTO `org_departamento` VALUES ('00003', 'SONSONATE');
INSERT INTO `org_departamento` VALUES ('00004', 'CHALATENANGO');
INSERT INTO `org_departamento` VALUES ('00005', 'LA LIBERTAD');
INSERT INTO `org_departamento` VALUES ('00006', 'SAN SALVADOR');
INSERT INTO `org_departamento` VALUES ('00007', 'CUSCATLÁN');
INSERT INTO `org_departamento` VALUES ('00008', 'LA PAZ');
INSERT INTO `org_departamento` VALUES ('00009', 'CABAÑAS');
INSERT INTO `org_departamento` VALUES ('00010', 'SAN VICENTE');
INSERT INTO `org_departamento` VALUES ('00011', 'USULUTÁN');
INSERT INTO `org_departamento` VALUES ('00012', 'SAN MIGUEL');
INSERT INTO `org_departamento` VALUES ('00013', 'MORAZÁN');
INSERT INTO `org_departamento` VALUES ('00014', 'LA UNIÓN');
INSERT INTO `org_departamento` VALUES ('00015', 'AHUCHAPAN');
INSERT INTO `org_departamento` VALUES ('00016', 'SANTA ANA');
INSERT INTO `org_departamento` VALUES ('00017', 'SONSONATE');
INSERT INTO `org_departamento` VALUES ('00018', 'CHALATENANGO');
INSERT INTO `org_departamento` VALUES ('00019', 'LA LIBERTAD');
INSERT INTO `org_departamento` VALUES ('00020', 'SAN SALVADOR');
INSERT INTO `org_departamento` VALUES ('00021', 'CUSCATLAN');
INSERT INTO `org_departamento` VALUES ('00022', 'LA PAZ');
INSERT INTO `org_departamento` VALUES ('00023', 'CABAÑAS');
INSERT INTO `org_departamento` VALUES ('00024', 'SAN VICENTE');
INSERT INTO `org_departamento` VALUES ('00025', 'USULUTAN');
INSERT INTO `org_departamento` VALUES ('00026', 'SAN MIGUEL');
INSERT INTO `org_departamento` VALUES ('00027', 'MORAZAN');
INSERT INTO `org_departamento` VALUES ('00028', 'LA UNION');

-- ----------------------------
-- Table structure for org_empleado
-- ----------------------------
DROP TABLE IF EXISTS `org_empleado`;
CREATE TABLE `org_empleado` (
  `NR` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `id_seccion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`NR`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of org_empleado
-- ----------------------------
INSERT INTO `org_empleado` VALUES ('1', 'Jhonatan Samuel', 'Flores Barahona', '108');
INSERT INTO `org_empleado` VALUES ('2', 'Oscar Roberto', 'Rojas Chirino', '108');
INSERT INTO `org_empleado` VALUES ('3', 'Leonel Adonis ', 'Peña Moran', '108');
INSERT INTO `org_empleado` VALUES ('4', 'Kaylee', 'Goad', '104');
INSERT INTO `org_empleado` VALUES ('5', 'Clelia Noemy', 'Reyes Lopez', '104');

-- ----------------------------
-- Table structure for org_fuente_fondo
-- ----------------------------
DROP TABLE IF EXISTS `org_fuente_fondo`;
CREATE TABLE `org_fuente_fondo` (
  `id_fuente_fondo` int(50) NOT NULL AUTO_INCREMENT,
  `nombre_fuente_fondo` varchar(100) DEFAULT NULL,
  `codigo_fuente_fondo` varchar(50) DEFAULT NULL,
  `descripcion_fuente_fondo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_fuente_fondo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_fuente_fondo
-- ----------------------------
INSERT INTO `org_fuente_fondo` VALUES ('1', 'GOES', '', '');
INSERT INTO `org_fuente_fondo` VALUES ('2', 'DONACION', 'DON01', 'desc');

-- ----------------------------
-- Table structure for org_genero
-- ----------------------------
DROP TABLE IF EXISTS `org_genero`;
CREATE TABLE `org_genero` (
  `id_genero` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `genero` varchar(10) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_genero
-- ----------------------------
INSERT INTO `org_genero` VALUES ('00001', 'MASCULINO');
INSERT INTO `org_genero` VALUES ('00002', 'FEMENINO');

-- ----------------------------
-- Table structure for org_mision_oficial
-- ----------------------------
DROP TABLE IF EXISTS `org_mision_oficial`;
CREATE TABLE `org_mision_oficial` (
  `id_mision_oficial` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `placa` varchar(10) NOT NULL,
  `id_solicitud` int(10) unsigned NOT NULL,
  `KmInicial` int(10) unsigned NOT NULL,
  `KmFinal` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_mision_oficial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_mision_oficial
-- ----------------------------

-- ----------------------------
-- Table structure for org_modulo
-- ----------------------------
DROP TABLE IF EXISTS `org_modulo`;
CREATE TABLE `org_modulo` (
  `id_modulo` int(50) NOT NULL AUTO_INCREMENT,
  `id_sistema` int(50) DEFAULT NULL,
  `nombre_modulo` varchar(150) DEFAULT NULL,
  `descripcion_modulo` varchar(250) DEFAULT NULL,
  `orden` int(10) DEFAULT NULL,
  `dependencia` int(5) DEFAULT NULL,
  `url_modulo` varchar(300) DEFAULT NULL,
  `img_modulo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_modulo
-- ----------------------------
INSERT INTO `org_modulo` VALUES ('1', '1', 'FACTURAS', '', '1', '0', 'mod=facturas&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('2', '1', 'PEDIDOS', '', '2', '0', 'mod=pedidos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('3', '1', 'PRODUCTOS', '', '3', '0', 'mod=productos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('4', '1', 'PROVEEDORES', '', '4', '0', 'mod=proveedores&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('5', '1', 'UNIDADES DE PRODUCTOS', '', '5', '0', 'mod=unidades de productos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('6', '1', 'REPORTES', '', '6', '0', 'mod=reportes', null);
INSERT INTO `org_modulo` VALUES ('7', '1', 'FUENTES DE FONDO', '', '7', '0', 'mod=fuentes de fondo&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('8', '1', 'OBJETO ESPECIFICO', '', '8', '0', 'mod=objeto especifico&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('9', '1', 'PERFIL', '', '10', '0', 'mod=perfil', null);
INSERT INTO `org_modulo` VALUES ('10', '1', 'CORTE', '', '9', '0', 'mod=corte&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('11', '2', 'SISTEMAS', '', '1', '0', 'mod=sistemas&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('12', '2', 'MODULOS', '', '2', '0', 'mod=modulos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('13', '2', 'ROLES', '', '3', '0', 'mod=roles&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('14', '2', 'PERMISOS', '', '4', '0', 'mod=permisos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('15', '2', 'USUARIOS', '', '5', '0', 'mod=usuarios&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('16', '2', 'USUARIO ROL', '', '6', '0', 'mod=usuario rol&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('17', '2', 'SECCIONES', '', '7', '0', 'mod=secciones&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('18', '1', 'CONTEO FISICO', '', '11', '0', 'mod=conteo fisico&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('19', '3', 'CATALOGOS', null, '1', '0', null, null);
INSERT INTO `org_modulo` VALUES ('20', '3', 'CUENTAS CONTABLES', null, '2', '19', 'mod=cuentas contables&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('21', '3', 'CATEGORIAS', null, '3', '19', 'mod=categorias&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('22', '3', 'SUB CATEGORIAS', null, '4', '19', 'mod=sub categorias&secc=seleccionar', null);
INSERT INTO `org_modulo` VALUES ('23', '3', 'MOVIMIENTOS', null, '5', '19', 'mod=movimientos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('24', '3', 'OFICINAS', null, '6', '19', 'mod=oficinas&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('25', '3', 'ALMACENES', null, '7', '19', 'mod=almacenes&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('26', '3', 'MARCAS', null, '8', '19', 'mod=marcas&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('27', '3', 'DOCUMENTOS', null, '9', '19', 'mod=documentos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('28', '3', 'CONDICION', null, '10', '19', 'mod=condicion&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('29', '3', 'PROYECTOS', null, '11', '19', 'mod=proyectos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('30', '3', 'REGISTRO', null, '12', '0', null, null);
INSERT INTO `org_modulo` VALUES ('31', '3', 'DATOS COMUNES', null, '13', '30', 'mod=datos comunes&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('32', '3', 'COD ACTIVOS', null, '14', '30', 'mod=cod activos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('33', '3', 'COD TERRENOS Y EDIF', null, '15', '30', 'mod=cod terrenos y edif&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('34', '3', 'REG MOVIMIENTOS', null, '17', '30', 'mod=reg movimientos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('35', '3', 'REPORTES', null, '18', '0', 'mod=reportes', null);
INSERT INTO `org_modulo` VALUES ('36', '3', 'PERFIL', null, '19', '0', 'mod=perfil', null);
INSERT INTO `org_modulo` VALUES ('37', '3', 'COD AUTOMOVILES', null, '16', '30', 'mod=cod autos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('38', '4', 'PERSONAL', 'Registro de información personal', '0', '0', 'mod=personal&secc=guardar&ses=0', null);
INSERT INTO `org_modulo` VALUES ('39', '4', 'EXPEDIENTES', 'Registro de información laboral del empleado', '1', '0', 'blank', null);
INSERT INTO `org_modulo` VALUES ('40', '4', 'CAPACITACION', 'Menú principal de capacitaciones', '2', '0', 'blank', null);
INSERT INTO `org_modulo` VALUES ('41', '4', 'CAPACITACIONES', 'Registro de capacitaciones', '3', '40', 'mod=capacitaciones&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('42', '4', 'CAPACITADORES', 'Registro de personal del MTPS que imparte capacitaciones', '4', '40', 'mod=capacitadores&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('43', '4', 'CATALOGOS', 'Menú principal de catálogos SFERH', '5', '0', 'blank.php', null);
INSERT INTO `org_modulo` VALUES ('44', '4', 'NIVEL ACADEMICO', 'Registro de niveles academicos', '6', '43', 'mod=nivel academico&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('45', '4', 'DOCUMENTOS', 'Catalogo de tipos de documentos usados en RRHH', '7', '43', 'mod=documentos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('46', '4', 'LICENCIAS', 'Catalogo de tipos de licencias usada en RRHH', '8', '43', 'mod=licencias&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('47', '4', 'CARGOS FUNCIONALES', 'Catalogo de cargos funcionales en RRHH', '9', '43', 'mod=cargos funcionales&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('48', '4', 'CARGOS NOMINALES', 'Catalogo de cargos nominales usados en RRHH', '10', '43', 'mod=cargos nominales&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('49', '4', 'REPORTES', 'Listado de reportes que se pueden generar en RRHH', '11', '0', 'rpt_sferh.php', null);
INSERT INTO `org_modulo` VALUES ('50', '4', 'EXPEDIENTE', 'Información general del expediente del empleado, se considera a futuro el registro de información del expediente (ubicación física u otros)', '12', '39', 'mod=expediente&secc=lista', null);
INSERT INTO `org_modulo` VALUES ('51', '4', 'LABORAL', 'Registro de información laboral del empleado', '13', '39', 'mod=laboral&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('52', '4', 'LICENCIA', 'Registro de las licencias del empleado', '14', '39', 'mod=licencia&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('53', '4', 'TITULOS', 'Registro de títulos del empleado ', '15', '39', 'mod=titulos&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('54', '4', 'FAMILIARES', 'Registro de familiares del empleado', '16', '39', 'mod=familiares&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('55', '4', 'RECORD', 'Registro del record del personal', '17', '39', 'mod=record&secc=lista', null);
INSERT INTO `org_modulo` VALUES ('56', '4', 'PERFIL', 'Cambio de credenciales', '18', '0', 'mod=perfil', null);
INSERT INTO `org_modulo` VALUES ('57', '3', 'PROVEEDORES', null, '17', '19', 'mod=proveedores&secc=guardar', null);
INSERT INTO `org_modulo` VALUES ('58', '5', 'Gestión de Transporte', 'Registro de solicitudes de Misiones Oficiales', '1', null, 'NULL', 'transporte.png');
INSERT INTO `org_modulo` VALUES ('59', '5', 'Crear solicitud de Misión Oficial', 'Ingreso de nueva solicitud de prestamo vehicular', '1', '58', 'transporte/solicitud', null);
INSERT INTO `org_modulo` VALUES ('60', '5', 'Control de solicitudes', 'Aprobar/Rechazar solicitudes hechas por los usuarios', '2', '58', 'transporte/control_solicitudes', null);
INSERT INTO `org_modulo` VALUES ('61', '5', 'Ver solicitudes', 'Ver el estado actual de las solicitudes hechas', '3', '58', 'transporte/ver_solicitudes', null);
INSERT INTO `org_modulo` VALUES ('62', '5', 'Asignación de vehículo/motorista', 'Establecer el vehículo y motorista a utilizar en una Misión Oficial', '4', '58', 'transporte/asignar_vehiculo_motorista', null);
INSERT INTO `org_modulo` VALUES ('63', '5', 'Pueba', 'Item de prueba', '1', '70', 'plan/solicitud', null);
INSERT INTO `org_modulo` VALUES ('64', '5', 'Control de salidas/entradas', 'Registro del estado inicial y final del vehículo', '5', '58', 'transporte/control_salidas_entradas', null);
INSERT INTO `org_modulo` VALUES ('65', '5', 'Reportes y formularios', 'Consolidado de datos para exportación a hoja electronica/pdf', '6', '58', 'NULL', null);
INSERT INTO `org_modulo` VALUES ('66', '5', 'Solicitud de Misión Oficial', 'Exportación a pdf de una solicitud', '1', '65', 'transporte/reporte_solicitud', null);
INSERT INTO `org_modulo` VALUES ('67', '5', 'Control de salidas/entradas', 'Exportación a hoja electrónica/pdf de los movimientos de los vehículos', '2', '65', 'transporte/reporte_salidas_entradas', null);
INSERT INTO `org_modulo` VALUES ('68', '5', 'Bitácora de vehículos', 'Exportación a hoja electrónica/pdf de los movimientos del historial de viajes por vehículo', '3', '65', 'transporte/bitacora_vehiculos', null);
INSERT INTO `org_modulo` VALUES ('69', '5', 'Rediminiento vehicular', 'Exportación a hoja electrónica/pdf del rendimiento por combustible de los vehículos', '4', '65', 'transporte/reporte_vehicular', null);
INSERT INTO `org_modulo` VALUES ('70', '5', 'Planes Anuales de Trabajo', 'Registro de la planificación anual', '2', null, 'NULL', 'plan.png');
INSERT INTO `org_modulo` VALUES ('71', '5', 'Cerrar Sesión', 'Salir del Sistema', '4', null, 'sessiones/cerrar_session', 'cerrar.png');
INSERT INTO `org_modulo` VALUES ('72', '5', 'Respaldos Base de Datos', 'Creación o restauración de un BackUp de la Base de Datos', '3', null, 'NULL', 'base.png');
INSERT INTO `org_modulo` VALUES ('73', '5', 'Crear BackUp', 'Crear punto de partida de la Base de Datos', '1', '72', 'respaldo/crear', null);
INSERT INTO `org_modulo` VALUES ('74', '5', 'Restaurar BackUp', 'Restaurar punto de partida de la Base de Datos', '2', '72', 'respaldo/restaurar', null);

-- ----------------------------
-- Table structure for org_municipio
-- ----------------------------
DROP TABLE IF EXISTS `org_municipio`;
CREATE TABLE `org_municipio` (
  `id_municipio` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `municipio` varchar(50) NOT NULL,
  `id_departamento_pais` int(5) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id_municipio`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_municipio
-- ----------------------------
INSERT INTO `org_municipio` VALUES ('00001', 'AHUACHAPAN', '00001');
INSERT INTO `org_municipio` VALUES ('00002', 'APANECA', '00001');
INSERT INTO `org_municipio` VALUES ('00003', 'ATIQUIZAYA', '00001');
INSERT INTO `org_municipio` VALUES ('00004', 'CONCEPCION DE ATACO', '00001');
INSERT INTO `org_municipio` VALUES ('00005', 'EL REFUGIO', '00001');
INSERT INTO `org_municipio` VALUES ('00006', 'GUAYMANGO', '00001');
INSERT INTO `org_municipio` VALUES ('00007', 'JUJUTLA', '00001');
INSERT INTO `org_municipio` VALUES ('00008', 'SAN LORENZO', '00001');
INSERT INTO `org_municipio` VALUES ('00009', 'SAN FRANCISCO MENENDEZ', '00001');
INSERT INTO `org_municipio` VALUES ('00010', 'SAN PEDRO PUXTLA', '00001');
INSERT INTO `org_municipio` VALUES ('00011', 'TACUBA', '00001');
INSERT INTO `org_municipio` VALUES ('00012', 'TURÍN', '00001');
INSERT INTO `org_municipio` VALUES ('00013', 'SANTA ANA', '00002');
INSERT INTO `org_municipio` VALUES ('00014', 'CANDELARIA DE LA FRONTERA', '00002');
INSERT INTO `org_municipio` VALUES ('00015', 'CHALCHUAPA', '00002');
INSERT INTO `org_municipio` VALUES ('00016', 'COATEPEQUE', '00002');
INSERT INTO `org_municipio` VALUES ('00017', 'EL CONGO', '00002');
INSERT INTO `org_municipio` VALUES ('00018', 'EL PORVENIR', '00002');
INSERT INTO `org_municipio` VALUES ('00019', 'MASAHUAT', '00002');
INSERT INTO `org_municipio` VALUES ('00020', 'METAPAN', '00002');
INSERT INTO `org_municipio` VALUES ('00021', 'SAN ANTONIO PAJONAL', '00002');
INSERT INTO `org_municipio` VALUES ('00022', 'SAN SEBASTIAN SALITRILLO', '00002');
INSERT INTO `org_municipio` VALUES ('00023', 'SANTA ROSA GUACHIPILIN', '00002');
INSERT INTO `org_municipio` VALUES ('00024', 'SANTIAGO DE LA FRONTERA', '00002');
INSERT INTO `org_municipio` VALUES ('00025', 'TEXISTEPEQUE', '00002');
INSERT INTO `org_municipio` VALUES ('00026', 'SONSONATE', '00003');
INSERT INTO `org_municipio` VALUES ('00027', 'ACAJUTLA', '00003');
INSERT INTO `org_municipio` VALUES ('00028', 'ARMENIA', '00003');
INSERT INTO `org_municipio` VALUES ('00029', 'CALUCO', '00003');
INSERT INTO `org_municipio` VALUES ('00030', 'CUISNAHUAT', '00003');
INSERT INTO `org_municipio` VALUES ('00031', 'IZALCO', '00003');
INSERT INTO `org_municipio` VALUES ('00032', 'JUAYUA', '00003');
INSERT INTO `org_municipio` VALUES ('00033', 'NAHUIZALCO', '00003');
INSERT INTO `org_municipio` VALUES ('00034', 'NAHULINGO', '00003');
INSERT INTO `org_municipio` VALUES ('00035', 'SALCOATITAN', '00003');
INSERT INTO `org_municipio` VALUES ('00036', 'SAN ANTONIO DEL MONTE', '00003');
INSERT INTO `org_municipio` VALUES ('00037', 'SAN JULIAN', '00003');
INSERT INTO `org_municipio` VALUES ('00038', 'SANTA CATARINA MASAHUAT', '00003');
INSERT INTO `org_municipio` VALUES ('00039', 'SANTA ISABEL ISHUATAN', '00003');
INSERT INTO `org_municipio` VALUES ('00040', 'SANTO DOMINGO DE GUZMAN', '00003');
INSERT INTO `org_municipio` VALUES ('00041', 'SONZACATE', '00003');
INSERT INTO `org_municipio` VALUES ('00042', 'CHALATENANGO', '00004');
INSERT INTO `org_municipio` VALUES ('00043', 'AGUA CALIENTE', '00004');
INSERT INTO `org_municipio` VALUES ('00044', 'ARCATAO', '00004');
INSERT INTO `org_municipio` VALUES ('00045', 'AZACUALPA', '00004');
INSERT INTO `org_municipio` VALUES ('00046', 'CANCASQUE', '00004');
INSERT INTO `org_municipio` VALUES ('00047', 'CITALA', '00004');
INSERT INTO `org_municipio` VALUES ('00048', 'COMALAPA', '00004');
INSERT INTO `org_municipio` VALUES ('00049', 'CONCEPCION QUEZALTEPEQUE', '00004');
INSERT INTO `org_municipio` VALUES ('00050', 'DULCE NOMBRE DE MARIA', '00004');
INSERT INTO `org_municipio` VALUES ('00051', 'EL CARRIZAL', '00004');
INSERT INTO `org_municipio` VALUES ('00052', 'EL PARAISO', '00004');
INSERT INTO `org_municipio` VALUES ('00053', 'LA LAGUNA', '00004');
INSERT INTO `org_municipio` VALUES ('00054', 'LA PALMA', '00004');
INSERT INTO `org_municipio` VALUES ('00055', 'LA REINA', '00004');
INSERT INTO `org_municipio` VALUES ('00056', 'LAS FLORES', '00004');
INSERT INTO `org_municipio` VALUES ('00057', 'LAS VUELTAS', '00004');
INSERT INTO `org_municipio` VALUES ('00058', 'NOMBRE DE JESUS', '00004');
INSERT INTO `org_municipio` VALUES ('00059', 'NUEVA CONCEPCION', '00004');
INSERT INTO `org_municipio` VALUES ('00060', 'NUEVA TRINIDAD', '00004');
INSERT INTO `org_municipio` VALUES ('00061', 'OJOS DE AGUA', '00004');
INSERT INTO `org_municipio` VALUES ('00062', 'POTONICO', '00004');
INSERT INTO `org_municipio` VALUES ('00063', 'SAN ANTONIO DE LA CRUZ', '00004');
INSERT INTO `org_municipio` VALUES ('00064', 'SAN ANTONIO LOS RANCHOS', '00004');
INSERT INTO `org_municipio` VALUES ('00065', 'SAN FERNANDO', '00004');
INSERT INTO `org_municipio` VALUES ('00066', 'SAN FRANCISCO LEMPA', '00004');
INSERT INTO `org_municipio` VALUES ('00067', 'SAN FRANCISCO MORAZAN', '00004');
INSERT INTO `org_municipio` VALUES ('00068', 'SAN IGNACIO', '00004');
INSERT INTO `org_municipio` VALUES ('00069', 'SAN ISIDRO LABRADOR', '00004');
INSERT INTO `org_municipio` VALUES ('00070', 'SAN LUIS DEL CARMEN', '00004');
INSERT INTO `org_municipio` VALUES ('00071', 'SAN MIGUEL DE MERCEDES', '00004');
INSERT INTO `org_municipio` VALUES ('00072', 'SAN RAFAEL', '00004');
INSERT INTO `org_municipio` VALUES ('00073', 'SANTA RITA', '00004');
INSERT INTO `org_municipio` VALUES ('00074', 'TEJUTLA', '00004');
INSERT INTO `org_municipio` VALUES ('00075', 'SANTA TECLA', '00005');
INSERT INTO `org_municipio` VALUES ('00076', 'ANTIGUO CUSCATLAN', '00005');
INSERT INTO `org_municipio` VALUES ('00077', 'CHILTIUPAN', '00005');
INSERT INTO `org_municipio` VALUES ('00078', 'CIUDAD ARCE', '00005');
INSERT INTO `org_municipio` VALUES ('00079', 'COLON', '00005');
INSERT INTO `org_municipio` VALUES ('00080', 'COMASAGUA', '00005');
INSERT INTO `org_municipio` VALUES ('00081', 'HUIZUCAR', '00005');
INSERT INTO `org_municipio` VALUES ('00082', 'JAYAQUE', '00005');
INSERT INTO `org_municipio` VALUES ('00083', 'JICALAPA', '00005');
INSERT INTO `org_municipio` VALUES ('00084', 'LA LIBERTAD', '00005');
INSERT INTO `org_municipio` VALUES ('00085', 'NUEVO CUSCATLAN', '00005');
INSERT INTO `org_municipio` VALUES ('00086', 'QUEZALTEPEQUE', '00005');
INSERT INTO `org_municipio` VALUES ('00087', 'SAN JUAN OPICO', '00005');
INSERT INTO `org_municipio` VALUES ('00088', 'SACACOYO', '00005');
INSERT INTO `org_municipio` VALUES ('00089', 'SAN JOSE VILLANUEVA', '00005');
INSERT INTO `org_municipio` VALUES ('00090', 'SAN MATIAS', '00005');
INSERT INTO `org_municipio` VALUES ('00091', 'SAN PABLO TACACHICO', '00005');
INSERT INTO `org_municipio` VALUES ('00092', 'TALNIQUE', '00005');
INSERT INTO `org_municipio` VALUES ('00093', 'TAMANIQUE', '00005');
INSERT INTO `org_municipio` VALUES ('00094', 'TEOTEPEQUE', '00005');
INSERT INTO `org_municipio` VALUES ('00095', 'TEPECOYO', '00005');
INSERT INTO `org_municipio` VALUES ('00096', 'ZARAGOZA', '00005');
INSERT INTO `org_municipio` VALUES ('00097', 'SAN SALVADOR', '00006');
INSERT INTO `org_municipio` VALUES ('00098', 'AGUILARES', '00006');
INSERT INTO `org_municipio` VALUES ('00099', 'APOPA', '00006');
INSERT INTO `org_municipio` VALUES ('00100', 'AYUTUXTEPEQUE', '00006');
INSERT INTO `org_municipio` VALUES ('00101', 'CUSCATANCINGO', '00006');
INSERT INTO `org_municipio` VALUES ('00102', 'CIUDAD DELGADO', '00006');
INSERT INTO `org_municipio` VALUES ('00103', 'EL PAISNAL', '00006');
INSERT INTO `org_municipio` VALUES ('00104', 'GUAZAPA', '00006');
INSERT INTO `org_municipio` VALUES ('00105', 'ILOPANGO', '00006');
INSERT INTO `org_municipio` VALUES ('00106', 'MEJICANOS', '00006');
INSERT INTO `org_municipio` VALUES ('00107', 'NEJAPA', '00006');
INSERT INTO `org_municipio` VALUES ('00108', 'PANCHIMALCO', '00006');
INSERT INTO `org_municipio` VALUES ('00109', 'ROSARIO DE MORA', '00006');
INSERT INTO `org_municipio` VALUES ('00110', 'SAN MARCOS', '00006');
INSERT INTO `org_municipio` VALUES ('00111', 'SAN MARTIN', '00006');
INSERT INTO `org_municipio` VALUES ('00112', 'SANTIAGO TEXACUANGOS', '00006');
INSERT INTO `org_municipio` VALUES ('00113', 'SANTO TOMAS', '00006');
INSERT INTO `org_municipio` VALUES ('00114', 'SOYAPANGO', '00006');
INSERT INTO `org_municipio` VALUES ('00115', 'TONACATEPEQUE', '00006');
INSERT INTO `org_municipio` VALUES ('00116', 'COJUTEPEQUE', '00007');
INSERT INTO `org_municipio` VALUES ('00117', 'CANDELARIA', '00007');
INSERT INTO `org_municipio` VALUES ('00118', 'EL CARMEN', '00007');
INSERT INTO `org_municipio` VALUES ('00119', 'EL ROSARIO', '00007');
INSERT INTO `org_municipio` VALUES ('00120', 'MONTE SAN JUAN', '00007');
INSERT INTO `org_municipio` VALUES ('00121', 'ORATORIO DE CONCEPCION', '00007');
INSERT INTO `org_municipio` VALUES ('00122', 'SAN BARTOLOME PERULAPIA', '00007');
INSERT INTO `org_municipio` VALUES ('00123', 'SAN CRISTOBAL', '00007');
INSERT INTO `org_municipio` VALUES ('00124', 'SAN JOSE GUAYABAL', '00007');
INSERT INTO `org_municipio` VALUES ('00125', 'SAN PEDRO PERULAPAN', '00007');
INSERT INTO `org_municipio` VALUES ('00126', 'SAN RAFAEL CEDROS', '00007');
INSERT INTO `org_municipio` VALUES ('00127', 'SAN RAMON', '00007');
INSERT INTO `org_municipio` VALUES ('00128', 'SANTA CRUZ ANALQUITO', '00007');
INSERT INTO `org_municipio` VALUES ('00129', 'SANTA CRUZ MICHAPA', '00007');
INSERT INTO `org_municipio` VALUES ('00130', 'SUCHITOTO', '00007');
INSERT INTO `org_municipio` VALUES ('00131', 'TENANCINGO', '00007');
INSERT INTO `org_municipio` VALUES ('00132', 'ZACATECOLUCA', '00008');
INSERT INTO `org_municipio` VALUES ('00133', 'CUYULTITAN', '00008');
INSERT INTO `org_municipio` VALUES ('00134', 'EL ROSARIO LA PAZ', '00008');
INSERT INTO `org_municipio` VALUES ('00135', 'JERUSALEN', '00008');
INSERT INTO `org_municipio` VALUES ('00136', 'MERCEDES LA CEIBA', '00008');
INSERT INTO `org_municipio` VALUES ('00137', 'OLOCUILTA', '00008');
INSERT INTO `org_municipio` VALUES ('00138', 'PARAISO DE OSORIO', '00008');
INSERT INTO `org_municipio` VALUES ('00139', 'SAN ANTONIO MASAHUAT', '00008');
INSERT INTO `org_municipio` VALUES ('00140', 'SAN EMIGDIO', '00008');
INSERT INTO `org_municipio` VALUES ('00141', 'SAN FRANCISCO CHINAMECA', '00008');
INSERT INTO `org_municipio` VALUES ('00142', 'SAN PEDRO MASAHUAT', '00008');
INSERT INTO `org_municipio` VALUES ('00143', 'SAN JUAN NONUALCO', '00008');
INSERT INTO `org_municipio` VALUES ('00144', 'SAN JUAN TALPA', '00008');
INSERT INTO `org_municipio` VALUES ('00145', 'SAN JUAN TEPEZONTES', '00008');
INSERT INTO `org_municipio` VALUES ('00146', 'SAN LUIS LA HERRADURA', '00008');
INSERT INTO `org_municipio` VALUES ('00147', 'SAN LUIS TALPA', '00008');
INSERT INTO `org_municipio` VALUES ('00148', 'SAN MIGUEL TEPEZONTES', '00008');
INSERT INTO `org_municipio` VALUES ('00149', 'SAN PEDRO NONUALCO', '00008');
INSERT INTO `org_municipio` VALUES ('00150', 'SAN RAFAEL OBRAJUELO', '00008');
INSERT INTO `org_municipio` VALUES ('00151', 'SANTA MARIA OSTUMA', '00008');
INSERT INTO `org_municipio` VALUES ('00152', 'SANTIAGO NONUALCO', '00008');
INSERT INTO `org_municipio` VALUES ('00153', 'TAPALHUACA', '00008');
INSERT INTO `org_municipio` VALUES ('00154', 'SENSUNTEPEQUE', '00009');
INSERT INTO `org_municipio` VALUES ('00155', 'CINQUERA', '00009');
INSERT INTO `org_municipio` VALUES ('00156', 'DOLORES', '00009');
INSERT INTO `org_municipio` VALUES ('00157', 'GUACOTECTI', '00009');
INSERT INTO `org_municipio` VALUES ('00158', 'ILOBASCO', '00009');
INSERT INTO `org_municipio` VALUES ('00159', 'JUTIAPA', '00009');
INSERT INTO `org_municipio` VALUES ('00160', 'SAN ISIDRO', '00009');
INSERT INTO `org_municipio` VALUES ('00161', 'TEJUTEPEQUE', '00009');
INSERT INTO `org_municipio` VALUES ('00162', 'VICTORIA', '00009');
INSERT INTO `org_municipio` VALUES ('00163', 'SAN VICENTE', '00010');
INSERT INTO `org_municipio` VALUES ('00164', 'APASTEPEQUE', '00010');
INSERT INTO `org_municipio` VALUES ('00165', 'GUADALUPE', '00010');
INSERT INTO `org_municipio` VALUES ('00166', 'SAN CAYETANO ISTEPEQUE', '00010');
INSERT INTO `org_municipio` VALUES ('00167', 'SAN ESTEBAN CATARINA', '00010');
INSERT INTO `org_municipio` VALUES ('00168', 'SAN ILDEFONSO', '00010');
INSERT INTO `org_municipio` VALUES ('00169', 'SAN LORENZO', '00010');
INSERT INTO `org_municipio` VALUES ('00170', 'SAN SEBASTIAN', '00010');
INSERT INTO `org_municipio` VALUES ('00171', 'SANTA CLARA', '00010');
INSERT INTO `org_municipio` VALUES ('00172', 'SANTO DOMINGO', '00010');
INSERT INTO `org_municipio` VALUES ('00173', 'TECOLUCA', '00010');
INSERT INTO `org_municipio` VALUES ('00174', 'TEPETITAN', '00010');
INSERT INTO `org_municipio` VALUES ('00175', 'VERAPAZ', '00010');
INSERT INTO `org_municipio` VALUES ('00176', 'USULUTAN', '00011');
INSERT INTO `org_municipio` VALUES ('00177', 'ALEGRIA', '00011');
INSERT INTO `org_municipio` VALUES ('00178', 'BERLIN', '00011');
INSERT INTO `org_municipio` VALUES ('00179', 'CALIFORNIA', '00011');
INSERT INTO `org_municipio` VALUES ('00180', 'CONCEPCION BATRES', '00011');
INSERT INTO `org_municipio` VALUES ('00181', 'EL TRIUNFO', '00011');
INSERT INTO `org_municipio` VALUES ('00182', 'EREGUAYQUIN', '00011');
INSERT INTO `org_municipio` VALUES ('00183', 'ESTANZUELAS', '00011');
INSERT INTO `org_municipio` VALUES ('00184', 'JIQUILISCO', '00011');
INSERT INTO `org_municipio` VALUES ('00185', 'JUCUAPA', '00011');
INSERT INTO `org_municipio` VALUES ('00186', 'JUCUARAN', '00011');
INSERT INTO `org_municipio` VALUES ('00187', 'MERCEDES UMANA', '00011');
INSERT INTO `org_municipio` VALUES ('00188', 'NUEVA GRANADA', '00011');
INSERT INTO `org_municipio` VALUES ('00189', 'OZATLAN', '00011');
INSERT INTO `org_municipio` VALUES ('00190', 'PUERTO EL TRIUNFO', '00011');
INSERT INTO `org_municipio` VALUES ('00191', 'SAN AGUSTIN', '00011');
INSERT INTO `org_municipio` VALUES ('00192', 'SAN BUENAVENTURA', '00011');
INSERT INTO `org_municipio` VALUES ('00193', 'SAN DIONISIO', '00011');
INSERT INTO `org_municipio` VALUES ('00194', 'SAN FRANCISCO JAVIER', '00011');
INSERT INTO `org_municipio` VALUES ('00195', 'SANTA ELENA', '00011');
INSERT INTO `org_municipio` VALUES ('00196', 'SANTA MARIA', '00011');
INSERT INTO `org_municipio` VALUES ('00197', 'SANTIAGO DE MARIA', '00011');
INSERT INTO `org_municipio` VALUES ('00198', 'TECAPAN', '00011');
INSERT INTO `org_municipio` VALUES ('00199', 'SAN MIGUEL', '00012');
INSERT INTO `org_municipio` VALUES ('00200', 'CAROLINA', '00012');
INSERT INTO `org_municipio` VALUES ('00201', 'CHAPELTIQUE', '00012');
INSERT INTO `org_municipio` VALUES ('00202', 'CHINAMECA', '00012');
INSERT INTO `org_municipio` VALUES ('00203', 'CHIRILAGUA', '00012');
INSERT INTO `org_municipio` VALUES ('00204', 'CIUDAD BARRIOS', '00012');
INSERT INTO `org_municipio` VALUES ('00205', 'COMACARAN', '00012');
INSERT INTO `org_municipio` VALUES ('00206', 'EL TRANSITO', '00012');
INSERT INTO `org_municipio` VALUES ('00207', 'LOLOTIQUE', '00012');
INSERT INTO `org_municipio` VALUES ('00208', 'MONCAGUA', '00012');
INSERT INTO `org_municipio` VALUES ('00209', 'NUEVA GUADALUPE', '00012');
INSERT INTO `org_municipio` VALUES ('00210', 'NUEVO EDEN DE SAN JUAN', '00012');
INSERT INTO `org_municipio` VALUES ('00211', 'QUELEPA', '00012');
INSERT INTO `org_municipio` VALUES ('00212', 'SAN ANTONIO', '00012');
INSERT INTO `org_municipio` VALUES ('00213', 'SAN GERARDO', '00012');
INSERT INTO `org_municipio` VALUES ('00214', 'SAN JORGE', '00012');
INSERT INTO `org_municipio` VALUES ('00215', 'SAN LUIS DE LA REINA', '00012');
INSERT INTO `org_municipio` VALUES ('00216', 'SAN RAFAEL ORIENTE', '00012');
INSERT INTO `org_municipio` VALUES ('00217', 'SESORI', '00012');
INSERT INTO `org_municipio` VALUES ('00218', 'ULUAZAPA', '00012');
INSERT INTO `org_municipio` VALUES ('00219', 'SAN FRANCISCO GOTERA', '00013');
INSERT INTO `org_municipio` VALUES ('00220', 'ARAMBALA', '00013');
INSERT INTO `org_municipio` VALUES ('00221', 'CACAOPERA', '00013');
INSERT INTO `org_municipio` VALUES ('00222', 'CHILANGA', '00013');
INSERT INTO `org_municipio` VALUES ('00223', 'CORINTO', '00013');
INSERT INTO `org_municipio` VALUES ('00224', 'DELICIAS DE CONCEPCION', '00013');
INSERT INTO `org_municipio` VALUES ('00225', 'EL DIVISADERO', '00013');
INSERT INTO `org_municipio` VALUES ('00226', 'EL ROSARIO', '00013');
INSERT INTO `org_municipio` VALUES ('00227', 'GUALOCOCTI', '00013');
INSERT INTO `org_municipio` VALUES ('00228', 'GUATAJIAGUA', '00013');
INSERT INTO `org_municipio` VALUES ('00229', 'JOATECA', '00013');
INSERT INTO `org_municipio` VALUES ('00230', 'JOCOAITIQUE', '00013');
INSERT INTO `org_municipio` VALUES ('00231', 'JOCORO', '00013');
INSERT INTO `org_municipio` VALUES ('00232', 'LOLOTIQUILLO', '00013');
INSERT INTO `org_municipio` VALUES ('00233', 'MEANGUERA', '00013');
INSERT INTO `org_municipio` VALUES ('00234', 'OSICALA', '00013');
INSERT INTO `org_municipio` VALUES ('00235', 'PERQUIN', '00013');
INSERT INTO `org_municipio` VALUES ('00236', 'SAN CARLOS', '00013');
INSERT INTO `org_municipio` VALUES ('00237', 'SAN FERNANDO', '00013');
INSERT INTO `org_municipio` VALUES ('00238', 'SAN ISIDRO', '00013');
INSERT INTO `org_municipio` VALUES ('00239', 'SAN SIMON', '00013');
INSERT INTO `org_municipio` VALUES ('00240', 'SENSEMBRA', '00013');
INSERT INTO `org_municipio` VALUES ('00241', 'SOCIEDAD', '00013');
INSERT INTO `org_municipio` VALUES ('00242', 'TOROLA', '00013');
INSERT INTO `org_municipio` VALUES ('00243', 'YAMABAL', '00013');
INSERT INTO `org_municipio` VALUES ('00244', 'YOLOAIQUIN', '00013');
INSERT INTO `org_municipio` VALUES ('00245', 'LA UNION', '00014');
INSERT INTO `org_municipio` VALUES ('00246', 'ANAMOROS', '00014');
INSERT INTO `org_municipio` VALUES ('00247', 'BOLIVAR', '00014');
INSERT INTO `org_municipio` VALUES ('00248', 'CONCEPCION DE ORIENTE', '00014');
INSERT INTO `org_municipio` VALUES ('00249', 'CONCHAGUA', '00014');
INSERT INTO `org_municipio` VALUES ('00250', 'EL CARMEN', '00014');
INSERT INTO `org_municipio` VALUES ('00251', 'EL SAUCE', '00014');
INSERT INTO `org_municipio` VALUES ('00252', 'INTIPUCA', '00014');
INSERT INTO `org_municipio` VALUES ('00253', 'LISLIQUE', '00014');
INSERT INTO `org_municipio` VALUES ('00254', 'MEANGUERA DEL GOLFO', '00014');
INSERT INTO `org_municipio` VALUES ('00255', 'NUEVA ESPARTA', '00014');
INSERT INTO `org_municipio` VALUES ('00256', 'PASAQUINA', '00014');
INSERT INTO `org_municipio` VALUES ('00257', 'POLOROS', '00014');
INSERT INTO `org_municipio` VALUES ('00258', 'SAN ALEJO', '00014');
INSERT INTO `org_municipio` VALUES ('00259', 'SAN JOSE', '00014');
INSERT INTO `org_municipio` VALUES ('00260', 'SANTA ROSA DE LIMA', '00014');
INSERT INTO `org_municipio` VALUES ('00261', 'YAYANTIQUE', '00014');
INSERT INTO `org_municipio` VALUES ('00262', 'YUCUAIQUIN', '00014');

-- ----------------------------
-- Table structure for org_nacionalidad
-- ----------------------------
DROP TABLE IF EXISTS `org_nacionalidad`;
CREATE TABLE `org_nacionalidad` (
  `id_nacionalidad` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(50) NOT NULL,
  PRIMARY KEY (`id_nacionalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_nacionalidad
-- ----------------------------
INSERT INTO `org_nacionalidad` VALUES ('00001', 'Salvadoreña');

-- ----------------------------
-- Table structure for org_oficina
-- ----------------------------
DROP TABLE IF EXISTS `org_oficina`;
CREATE TABLE `org_oficina` (
  `id_oficina` int(10) NOT NULL AUTO_INCREMENT,
  `id_seccion_has_almacen` int(10) DEFAULT NULL,
  `nombre_oficina` varchar(200) DEFAULT NULL,
  `id_guarda` int(10) DEFAULT NULL,
  `id_actualiza` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_oficina`)
) ENGINE=InnoDB AUTO_INCREMENT=409 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_oficina
-- ----------------------------
INSERT INTO `org_oficina` VALUES ('1', '1', 'JEFATURA', '7', '3');
INSERT INTO `org_oficina` VALUES ('2', '32', 'BODEGA EXTERNA', '7', '7');
INSERT INTO `org_oficina` VALUES ('3', '1', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('4', '1', 'SUB-DIRECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('5', '17', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('6', '17', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('7', '2', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('8', '2', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('9', '2', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('10', '33', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('11', '3', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('12', '3', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('13', '3', 'BODEGA INTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('14', '4', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('15', '4', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('16', '5', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('17', '5', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('18', '6', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('19', '6', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('20', '7', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('21', '7', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('22', '34', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('23', '8', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('24', '8', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('25', '47', 'RESGUARDO SEMINTRAB', '7', null);
INSERT INTO `org_oficina` VALUES ('26', '9', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('27', '9', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('28', '9', 'BODEGA INTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('29', '35', 'BIENES OBSOLETOS RESG.', '7', null);
INSERT INTO `org_oficina` VALUES ('30', '10', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('31', '10', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('32', '11', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('33', '11', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('34', '11', 'CUARTO SERVIDORES', '7', null);
INSERT INTO `org_oficina` VALUES ('35', '36', 'EQUIPO DE RED Y COMUNICACION', '7', null);
INSERT INTO `org_oficina` VALUES ('36', '37', 'EQUIPO DE RED Y COMUNICACION', '7', null);
INSERT INTO `org_oficina` VALUES ('37', '38', 'EQUIPO DE RED Y COMUNICACION', '7', null);
INSERT INTO `org_oficina` VALUES ('38', '39', 'EQUIPO DE RED Y COMUNICACION', '7', null);
INSERT INTO `org_oficina` VALUES ('39', '40', 'EQUIPO DE RED Y COMUNICACION', '7', null);
INSERT INTO `org_oficina` VALUES ('40', '48', 'EQUIPO DE RED Y COMUNICACION', '7', null);
INSERT INTO `org_oficina` VALUES ('41', '12', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('42', '12', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('43', '13', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('44', '13', 'SALA DE REUNION', '7', null);
INSERT INTO `org_oficina` VALUES ('45', '13', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('46', '14', 'DESPACHO TITULAR', '7', null);
INSERT INTO `org_oficina` VALUES ('47', '14', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('48', '14', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('49', '14', 'BODEGA INTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('50', '42', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('51', '16', 'DESPACHO TITULAR', '7', null);
INSERT INTO `org_oficina` VALUES ('52', '16', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('53', '16', 'SALA DE REUNION', '7', null);
INSERT INTO `org_oficina` VALUES ('54', '43', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('55', '19', 'OFICINA ADMINISTRATIVA', '7', '7');
INSERT INTO `org_oficina` VALUES ('56', '19', 'SALA DE ORDENANZAS', '7', '7');
INSERT INTO `org_oficina` VALUES ('57', '19', 'MECANICOS', '7', '7');
INSERT INTO `org_oficina` VALUES ('58', '19', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('59', '19', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('60', '19', 'INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('61', '49', 'BIENES INTENDENCIA', '7', '7');
INSERT INTO `org_oficina` VALUES ('62', '51', 'BIENES INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('63', '52', 'BIENES INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('64', '53', 'BIENES INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('65', '54', 'BIENES INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('66', '55', 'BIENES INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('67', '56', 'BIENES INTENDENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('68', '20', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('69', '20', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('70', '20', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('71', '20', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('72', '20', 'BODEGA INTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('73', '45', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('74', '46', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('75', '22', 'SECCION ARCHIVO', '7', '7');
INSERT INTO `org_oficina` VALUES ('76', '59', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('77', '59', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('78', '60', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('79', '60', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('80', '61', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('81', '61', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('82', '61', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('83', '26', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('84', '26', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('85', '27', 'OFICINA ADMINISTRATIVA', '7', null);
INSERT INTO `org_oficina` VALUES ('86', '64', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('87', '64', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('88', '64', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('89', '29', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('90', '29', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('91', '29', 'SALA DE REUNION', '7', null);
INSERT INTO `org_oficina` VALUES ('92', '30', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('93', '30', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('94', '67', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('95', '67', 'PROTOCOLO', '7', null);
INSERT INTO `org_oficina` VALUES ('96', '67', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('97', '67', 'BODEGA INTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('98', '68', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('99', '69', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('100', '69', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('101', '69', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('102', '69', 'SALA DE REUNION', '7', null);
INSERT INTO `org_oficina` VALUES ('103', '70', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('104', '70', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('105', '71', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('106', '71', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('107', '71', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('108', '72', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('109', '72', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('110', '72', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('111', '73', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('112', '73', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('113', '73', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('114', '69', 'SUB-DIRECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('115', '74', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('116', '74', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('117', '75', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('118', '75', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('119', '75', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('120', '76', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('121', '76', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('122', '76', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('123', '77', 'OFICINA ADMINISTRATIVA', '7', null);
INSERT INTO `org_oficina` VALUES ('124', '78', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('125', '78', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('126', '78', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('127', '78', 'BODEGA INTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('128', '79', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('129', '79', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('130', '80', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('131', '80', 'SUB-DIRECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('132', '80', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('133', '80', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('134', '82', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('135', '82', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('136', '82', 'SALA DE REUNION', '7', null);
INSERT INTO `org_oficina` VALUES ('137', '83', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('138', '83', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('139', '84', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('140', '84', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('141', '85', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('142', '85', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('143', '86', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('144', '86', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('145', '86', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('146', '87', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('147', '87', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('148', '88', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('149', '89', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('150', '89', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('151', '89', 'SALA CONCILIACION', '7', null);
INSERT INTO `org_oficina` VALUES ('152', '90', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('153', '90', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('154', '91', 'NOTIFICADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('155', '91', 'DIALOGO SOCIAL', '7', null);
INSERT INTO `org_oficina` VALUES ('156', '92', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('157', '92', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('158', '93', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('159', '93', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('160', '94', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('161', '94', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('162', '95', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('163', '95', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('164', '95', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('165', '96', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('166', '96', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('167', '97', 'COLABORADORES BANCO MUNDIAL', '7', null);
INSERT INTO `org_oficina` VALUES ('168', '98', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('169', '98', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('170', '99', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('171', '99', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('172', '95', 'COORDINACION DE INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('173', '100', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('174', '100', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('175', '101', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('176', '101', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('177', '103', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('178', '103', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('179', '103', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('180', '103', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('181', '103', 'BODEGA EXTERNA', '7', null);
INSERT INTO `org_oficina` VALUES ('182', '104', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('183', '104', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('184', '105', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('185', '105', 'COLABORADORES', '7', null);
INSERT INTO `org_oficina` VALUES ('186', '106', 'OFICINA ADMINISTRATIVA', '7', null);
INSERT INTO `org_oficina` VALUES ('187', '107', 'CANCILLERIA RR.EE', '7', null);
INSERT INTO `org_oficina` VALUES ('188', '108', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('189', '108', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('190', '108', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('191', '108', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('192', '108', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('193', '108', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('194', '108', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('195', '108', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('196', '108', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('197', '108', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('198', '108', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('199', '108', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('200', '108', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('201', '109', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('202', '109', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('203', '109', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('204', '109', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('205', '109', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('206', '109', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('207', '109', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('208', '109', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('209', '109', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('210', '109', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('211', '109', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('212', '109', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('213', '109', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('214', '110', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('215', '110', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('216', '110', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('217', '110', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('218', '110', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('219', '110', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('220', '110', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('221', '110', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('222', '110', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('223', '110', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('224', '110', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('225', '110', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('226', '111', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('227', '111', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('228', '111', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('229', '111', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('230', '111', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('231', '111', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('232', '111', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('233', '111', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('234', '111', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('235', '111', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('236', '111', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('237', '111', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('238', '111', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('239', '112', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('240', '112', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('241', '112', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('242', '112', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('243', '112', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('244', '112', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('245', '112', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('246', '112', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('247', '112', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('248', '112', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('249', '112', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('250', '112', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('251', '112', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('252', '113', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('253', '113', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('254', '113', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('255', '113', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('256', '113', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('257', '113', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('258', '113', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('259', '113', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('260', '113', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('261', '113', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('262', '113', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('263', '113', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('264', '113', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('265', '114', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('266', '114', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('267', '114', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('268', '114', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('269', '114', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('270', '114', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('271', '114', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('272', '114', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('273', '114', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('274', '114', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('275', '114', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('276', '114', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('277', '114', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('278', '115', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('279', '115', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('280', '115', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('281', '115', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('282', '115', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('283', '115', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('284', '115', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('285', '115', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('286', '115', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('287', '115', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('288', '115', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('289', '115', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('290', '115', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('291', '116', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('292', '116', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('293', '116', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('294', '116', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('295', '116', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('296', '116', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('297', '116', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('298', '116', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('299', '116', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('300', '116', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('301', '116', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('302', '116', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('303', '116', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('304', '117', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('305', '117', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('306', '117', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('307', '117', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('308', '117', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('309', '117', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('310', '117', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('311', '117', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('312', '117', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('313', '117', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('314', '117', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('315', '117', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('316', '117', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('317', '118', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('318', '118', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('319', '118', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('320', '118', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('321', '118', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('322', '118', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('323', '118', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('324', '118', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('325', '118', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('326', '118', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('327', '118', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('328', '118', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('329', '118', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('330', '119', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('331', '119', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('332', '119', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('333', '119', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('334', '119', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('335', '119', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('336', '119', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('337', '119', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('338', '119', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('339', '119', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('340', '119', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('341', '119', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('342', '119', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('343', '120', 'JEFATURA', '7', null);
INSERT INTO `org_oficina` VALUES ('344', '120', 'RECEPCION', '7', null);
INSERT INTO `org_oficina` VALUES ('345', '120', 'INSPECCION', '7', null);
INSERT INTO `org_oficina` VALUES ('346', '120', 'DELEGADOS', '7', null);
INSERT INTO `org_oficina` VALUES ('347', '120', 'EMPLEO', '7', null);
INSERT INTO `org_oficina` VALUES ('348', '120', 'SEGURIDAD E HIGIENE', '7', null);
INSERT INTO `org_oficina` VALUES ('349', '120', 'VIGILANCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('350', '120', 'BODEGA', '7', null);
INSERT INTO `org_oficina` VALUES ('351', '120', 'TRANSPORTE', '7', null);
INSERT INTO `org_oficina` VALUES ('352', '120', 'SALA DE CAPACITACION', '7', null);
INSERT INTO `org_oficina` VALUES ('353', '120', 'SALA AUDIENCIA', '7', null);
INSERT INTO `org_oficina` VALUES ('354', '120', 'CENTRO DE COMPUTO', '7', null);
INSERT INTO `org_oficina` VALUES ('355', '120', 'AREA DE COCINA', '7', null);
INSERT INTO `org_oficina` VALUES ('356', '121', 'ADMINISTRACION', '7', null);
INSERT INTO `org_oficina` VALUES ('357', '121', 'GENERAL', '7', null);
INSERT INTO `org_oficina` VALUES ('358', '122', 'ADMINISTRACION', '7', null);
INSERT INTO `org_oficina` VALUES ('359', '122', 'GENERAL', '7', null);
INSERT INTO `org_oficina` VALUES ('360', '123', 'ADMINISTRACION', '7', null);
INSERT INTO `org_oficina` VALUES ('361', '123', 'GENERAL', '7', null);
INSERT INTO `org_oficina` VALUES ('362', '124', 'ADMINISTRACION', '7', null);
INSERT INTO `org_oficina` VALUES ('363', '124', 'GENERAL', '7', null);
INSERT INTO `org_oficina` VALUES ('364', '127', 'RESGUARDO ', '7', '7');
INSERT INTO `org_oficina` VALUES ('365', '128', 'BEL APOPA', '7', '7');
INSERT INTO `org_oficina` VALUES ('366', '128', 'BEL ILOPANGO', '7', null);
INSERT INTO `org_oficina` VALUES ('367', '128', 'BEL NEJAPA', '7', null);
INSERT INTO `org_oficina` VALUES ('368', '128', 'BEL MEJICANOS', '7', null);
INSERT INTO `org_oficina` VALUES ('369', '128', 'BEL SAN MARCOS', '7', null);
INSERT INTO `org_oficina` VALUES ('370', '128', 'BEL ALCALDIA SAN MARTIN', '7', null);
INSERT INTO `org_oficina` VALUES ('371', '128', 'BEL C.MUJER SAN MARTIN', '7', null);
INSERT INTO `org_oficina` VALUES ('372', '128', 'BEL NEJAPA', '7', null);
INSERT INTO `org_oficina` VALUES ('373', '128', 'BEL SOYAPANGO', '7', null);
INSERT INTO `org_oficina` VALUES ('374', '128', 'BEL ACAJUTLA', '7', null);
INSERT INTO `org_oficina` VALUES ('375', '128', 'BEL IZALCO', '7', null);
INSERT INTO `org_oficina` VALUES ('376', '128', 'BEL SANTA ANA', '7', null);
INSERT INTO `org_oficina` VALUES ('377', '128', 'BEL C.MUJER LOURDES', '7', null);
INSERT INTO `org_oficina` VALUES ('378', '128', 'BEL CIUDAD ARCE', '7', null);
INSERT INTO `org_oficina` VALUES ('379', '128', 'BEL PTO. LA LIBERTAD', '7', null);
INSERT INTO `org_oficina` VALUES ('380', '128', 'BEL QUEZALTEPEQUE', '7', null);
INSERT INTO `org_oficina` VALUES ('381', '128', 'BEL SAN JUAN OPICO', '7', null);
INSERT INTO `org_oficina` VALUES ('382', '128', 'BEL ZARAGOZA', '7', null);
INSERT INTO `org_oficina` VALUES ('383', '128', 'BEL CHINAMECA', '7', null);
INSERT INTO `org_oficina` VALUES ('384', '128', 'BEL OSICALA', '7', null);
INSERT INTO `org_oficina` VALUES ('385', '128', 'BEL JIQUILISCO', '7', null);
INSERT INTO `org_oficina` VALUES ('386', '128', 'BEL SANTIAGO DE MARIA', '7', null);
INSERT INTO `org_oficina` VALUES ('387', '128', 'BEL C.MUJER USULUTAN', '7', null);
INSERT INTO `org_oficina` VALUES ('388', '128', 'BEL NVA.CONCEPCION CHALATENANGO', '7', null);
INSERT INTO `org_oficina` VALUES ('389', '128', 'BEL SANTA ROSA DE LIMA', '7', null);
INSERT INTO `org_oficina` VALUES ('390', '15', 'DIRECCION DE RELACIONES INTERNACIONALES DE TRABAJO', '7', null);
INSERT INTO `org_oficina` VALUES ('391', '21', 'CLINICA EMPRESARIAL', '7', null);
INSERT INTO `org_oficina` VALUES ('392', '135', 'CAFETERIA', '7', null);
INSERT INTO `org_oficina` VALUES ('393', '19', 'MANTENIMIENTO', '7', null);
INSERT INTO `org_oficina` VALUES ('394', '136', 'UNIDAD DE ACCESO A LA INFORMACION PUBLICA', '7', null);
INSERT INTO `org_oficina` VALUES ('395', '137', 'CORTE DE CUENTAS', '7', null);
INSERT INTO `org_oficina` VALUES ('396', '138', 'CNR', '7', null);
INSERT INTO `org_oficina` VALUES ('397', '129', 'SECCION GENERAL E2 N1', '7', null);
INSERT INTO `org_oficina` VALUES ('398', '130', 'SECCION GENERAL E2 N2', '7', null);
INSERT INTO `org_oficina` VALUES ('399', '131', 'SECCION GENERAL E3 N1', '7', null);
INSERT INTO `org_oficina` VALUES ('400', '132', 'SECCION GENERAL E3 N2', '7', null);
INSERT INTO `org_oficina` VALUES ('401', '133', 'SECCION GENERAL E4 N1', '7', null);
INSERT INTO `org_oficina` VALUES ('402', '134', 'SECCION GENERAL E4 N2', '7', null);
INSERT INTO `org_oficina` VALUES ('403', '20', 'ANEXO RECURSOS HUMANOS', '7', null);
INSERT INTO `org_oficina` VALUES ('404', '140', 'ANEXO EDIFICACIONES', '7', null);
INSERT INTO `org_oficina` VALUES ('405', '141', 'JEFATURA', '21', null);
INSERT INTO `org_oficina` VALUES ('406', '110', 'PREVENSION DE RIESGOS', '21', null);
INSERT INTO `org_oficina` VALUES ('407', '142', 'JEFATURA', '21', null);
INSERT INTO `org_oficina` VALUES ('408', '143', 'JEFATURA', '21', null);

-- ----------------------------
-- Table structure for org_pagaduria
-- ----------------------------
DROP TABLE IF EXISTS `org_pagaduria`;
CREATE TABLE `org_pagaduria` (
  `id_pagaduria` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pagaduria` varchar(100) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_pagaduria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_pagaduria
-- ----------------------------
INSERT INTO `org_pagaduria` VALUES ('00001', 'REGIÓN CENTRAL', '');
INSERT INTO `org_pagaduria` VALUES ('00002', 'REGIÓN OCCIDENTAL', '');
INSERT INTO `org_pagaduria` VALUES ('00003', 'REGION ORIENTAL', '');
INSERT INTO `org_pagaduria` VALUES ('00004', 'REGIÓN PARACENTRAL', '');

-- ----------------------------
-- Table structure for org_permiso
-- ----------------------------
DROP TABLE IF EXISTS `org_permiso`;
CREATE TABLE `org_permiso` (
  `id_permiso` int(50) NOT NULL AUTO_INCREMENT,
  `permiso` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_permiso
-- ----------------------------
INSERT INTO `org_permiso` VALUES ('1', 'SELECT');
INSERT INTO `org_permiso` VALUES ('2', 'INSERT');
INSERT INTO `org_permiso` VALUES ('3', 'DELETE');
INSERT INTO `org_permiso` VALUES ('4', 'UPDATE');

-- ----------------------------
-- Table structure for org_rol
-- ----------------------------
DROP TABLE IF EXISTS `org_rol`;
CREATE TABLE `org_rol` (
  `id_rol` int(50) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(100) DEFAULT NULL,
  `descripcion_rol` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_rol
-- ----------------------------
INSERT INTO `org_rol` VALUES ('1', 'BODEGA', 'USUARIO DE BODEGA');
INSERT INTO `org_rol` VALUES ('2', 'SIB_REPORTES', 'USUARIO DE BODEGA REPORTES');
INSERT INTO `org_rol` VALUES ('3', 'ADMINISTRADOR', 'ADMIN');
INSERT INTO `org_rol` VALUES ('4', 'SAF_ADMINISTRADOR', 'USUARIO ADMINISTRADOR SISTEMA DE ACTIVO FIJO');
INSERT INTO `org_rol` VALUES ('5', 'SAF_USUARIO', 'USUARIO SISTEMA DE ACTIVO FIJO');
INSERT INTO `org_rol` VALUES ('6', 'REGISTRO DE PERSONAL', 'Rol para registro de personal de RRHH');
INSERT INTO `org_rol` VALUES ('7', 'ADMINISTRACION DE EXPEDIENTES', 'Rol que administra los expedientes de RRHH');
INSERT INTO `org_rol` VALUES ('8', 'CAPACITACIONES', 'Rol de la sección de capacitaciones');
INSERT INTO `org_rol` VALUES ('9', 'ADMINISTRACIÓN DE EXPEDIENTES Y PERSONAL', 'ROL DE PERSONAL CON FUNCIÓN DUAL');
INSERT INTO `org_rol` VALUES ('10', 'JEFE RRHH', 'JEFE DEL DEPARTAMENTO DE RRHH');
INSERT INTO `org_rol` VALUES ('11', 'ADMINISTRADOR SITCOM', 'Administrador del módulo de transporte');

-- ----------------------------
-- Table structure for org_rol_modulo_permiso
-- ----------------------------
DROP TABLE IF EXISTS `org_rol_modulo_permiso`;
CREATE TABLE `org_rol_modulo_permiso` (
  `id_rol_permiso` int(50) NOT NULL AUTO_INCREMENT,
  `id_rol` int(50) NOT NULL,
  `id_modulo` int(50) NOT NULL,
  `id_permiso` int(50) NOT NULL,
  `estado` int(1) NOT NULL,
  PRIMARY KEY (`id_rol_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=656 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_rol_modulo_permiso
-- ----------------------------
INSERT INTO `org_rol_modulo_permiso` VALUES ('1', '1', '1', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('2', '1', '1', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('3', '1', '1', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('4', '1', '1', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('5', '1', '2', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('6', '1', '2', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('7', '1', '2', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('8', '1', '2', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('9', '1', '3', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('10', '1', '3', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('11', '1', '3', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('12', '1', '3', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('13', '1', '4', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('14', '1', '4', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('15', '1', '4', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('16', '1', '4', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('17', '1', '5', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('18', '1', '5', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('19', '1', '5', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('20', '1', '5', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('21', '1', '6', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('22', '1', '6', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('23', '1', '6', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('24', '1', '6', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('25', '1', '7', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('26', '1', '7', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('27', '1', '7', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('28', '1', '7', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('29', '1', '8', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('30', '1', '8', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('31', '1', '8', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('32', '1', '8', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('37', '1', '9', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('38', '1', '9', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('39', '1', '9', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('40', '1', '9', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('41', '2', '1', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('42', '2', '1', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('43', '2', '1', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('44', '2', '1', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('45', '2', '2', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('46', '2', '2', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('47', '2', '2', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('48', '2', '2', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('49', '2', '3', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('50', '2', '3', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('51', '2', '3', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('52', '2', '3', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('53', '2', '4', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('54', '2', '4', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('55', '2', '4', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('56', '2', '4', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('57', '2', '5', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('58', '2', '5', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('59', '2', '5', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('60', '2', '5', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('61', '2', '6', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('62', '2', '6', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('63', '2', '6', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('64', '2', '6', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('65', '2', '7', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('66', '2', '7', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('67', '2', '7', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('68', '2', '7', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('69', '2', '8', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('70', '2', '8', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('71', '2', '8', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('72', '2', '8', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('73', '2', '9', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('74', '2', '9', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('75', '2', '9', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('76', '2', '9', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('77', '1', '10', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('78', '1', '10', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('79', '1', '10', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('80', '1', '10', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('81', '3', '11', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('82', '3', '11', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('83', '3', '11', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('84', '3', '11', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('85', '3', '12', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('86', '3', '12', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('87', '3', '12', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('88', '3', '12', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('89', '3', '13', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('90', '3', '13', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('91', '3', '13', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('92', '3', '13', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('93', '3', '14', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('94', '3', '14', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('95', '3', '14', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('96', '3', '14', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('97', '3', '15', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('98', '3', '15', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('99', '3', '15', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('100', '3', '15', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('101', '3', '16', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('102', '3', '16', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('103', '3', '16', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('104', '3', '16', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('105', '3', '17', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('106', '3', '17', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('107', '3', '17', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('108', '3', '17', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('109', '1', '18', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('110', '1', '18', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('111', '1', '18', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('112', '1', '18', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('113', '4', '19', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('114', '4', '19', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('115', '4', '19', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('116', '4', '19', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('117', '4', '20', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('118', '4', '20', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('119', '4', '20', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('120', '4', '20', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('121', '4', '21', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('122', '4', '21', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('123', '4', '21', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('124', '4', '21', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('125', '4', '22', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('126', '4', '22', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('127', '4', '22', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('128', '4', '22', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('129', '4', '23', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('130', '4', '23', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('131', '4', '23', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('132', '4', '23', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('133', '4', '24', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('134', '4', '24', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('135', '4', '24', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('136', '4', '24', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('137', '4', '25', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('138', '4', '25', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('139', '4', '25', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('140', '4', '25', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('141', '4', '26', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('142', '4', '26', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('143', '4', '26', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('144', '4', '26', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('145', '4', '27', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('146', '4', '27', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('147', '4', '27', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('148', '4', '27', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('149', '4', '28', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('150', '4', '28', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('151', '4', '28', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('152', '4', '28', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('153', '4', '29', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('154', '4', '29', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('155', '4', '29', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('156', '4', '29', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('157', '4', '30', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('158', '4', '30', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('159', '4', '30', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('160', '4', '30', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('161', '4', '31', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('162', '4', '31', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('163', '4', '31', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('164', '4', '31', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('165', '4', '32', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('166', '4', '32', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('167', '4', '32', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('168', '4', '32', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('169', '4', '33', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('170', '4', '33', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('171', '4', '33', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('172', '4', '33', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('173', '4', '34', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('174', '4', '34', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('175', '4', '34', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('176', '4', '34', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('177', '4', '35', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('178', '4', '35', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('179', '4', '35', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('180', '4', '35', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('181', '4', '36', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('182', '4', '36', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('183', '4', '36', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('184', '4', '36', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('185', '4', '37', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('186', '4', '37', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('187', '4', '37', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('188', '4', '37', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('246', '5', '19', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('247', '5', '19', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('248', '5', '19', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('249', '5', '19', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('250', '5', '20', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('251', '5', '20', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('252', '5', '20', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('253', '5', '20', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('254', '5', '21', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('255', '5', '21', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('256', '5', '21', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('257', '5', '21', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('258', '5', '22', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('259', '5', '22', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('260', '5', '22', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('261', '5', '22', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('262', '5', '23', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('263', '5', '23', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('264', '5', '23', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('265', '5', '23', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('266', '5', '24', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('267', '5', '24', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('268', '5', '24', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('269', '5', '24', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('270', '5', '25', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('271', '5', '25', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('272', '5', '25', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('273', '5', '25', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('274', '5', '26', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('275', '5', '26', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('276', '5', '26', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('277', '5', '26', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('278', '5', '27', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('279', '5', '27', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('280', '5', '27', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('281', '5', '27', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('282', '5', '28', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('283', '5', '28', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('284', '5', '28', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('285', '5', '28', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('286', '5', '29', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('287', '5', '29', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('288', '5', '29', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('289', '5', '29', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('290', '5', '30', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('291', '5', '30', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('292', '5', '30', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('293', '5', '30', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('294', '5', '31', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('295', '5', '31', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('296', '5', '31', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('297', '5', '31', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('298', '5', '32', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('299', '5', '32', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('300', '5', '32', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('301', '5', '32', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('302', '5', '33', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('303', '5', '33', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('304', '5', '33', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('305', '5', '33', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('306', '5', '34', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('307', '5', '34', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('308', '5', '34', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('309', '5', '34', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('310', '5', '35', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('311', '5', '35', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('312', '5', '35', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('313', '5', '35', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('314', '5', '36', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('315', '5', '36', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('316', '5', '36', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('317', '5', '36', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('318', '5', '37', '1', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('319', '5', '37', '2', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('320', '5', '37', '3', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('321', '5', '37', '4', '0');
INSERT INTO `org_rol_modulo_permiso` VALUES ('322', '4', '10', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('323', '4', '10', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('324', '4', '10', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('325', '4', '10', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('326', '4', '11', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('327', '4', '11', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('328', '4', '11', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('329', '4', '11', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('330', '4', '15', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('331', '4', '15', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('332', '4', '15', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('333', '4', '15', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('334', '4', '16', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('335', '4', '16', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('336', '4', '16', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('337', '4', '16', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('338', '4', '17', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('339', '4', '17', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('340', '4', '17', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('341', '4', '17', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('342', '4', '18', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('343', '4', '18', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('344', '4', '18', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('345', '4', '18', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('346', '4', '21', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('347', '4', '21', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('348', '4', '21', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('349', '4', '21', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('350', '4', '23', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('351', '4', '23', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('352', '4', '23', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('353', '4', '23', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('354', '4', '29', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('355', '4', '29', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('356', '4', '29', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('357', '4', '29', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('358', '5', '11', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('359', '5', '11', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('360', '5', '11', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('361', '5', '11', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('362', '5', '23', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('363', '5', '23', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('364', '5', '23', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('365', '5', '23', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('366', '5', '24', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('367', '5', '24', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('368', '5', '24', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('369', '5', '24', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('370', '5', '25', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('371', '5', '25', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('372', '5', '25', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('373', '5', '25', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('374', '5', '26', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('375', '5', '26', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('376', '5', '26', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('377', '5', '26', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('378', '5', '27', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('379', '5', '27', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('380', '5', '27', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('381', '5', '27', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('382', '5', '28', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('383', '5', '28', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('384', '5', '28', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('385', '5', '28', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('386', '5', '29', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('387', '5', '29', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('388', '5', '29', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('389', '5', '29', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('446', '6', '38', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('447', '6', '38', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('448', '6', '38', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('449', '6', '38', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('450', '6', '39', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('451', '6', '39', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('452', '6', '39', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('453', '6', '39', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('454', '6', '43', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('455', '6', '43', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('456', '6', '43', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('457', '6', '43', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('458', '6', '44', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('459', '6', '44', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('460', '6', '44', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('461', '6', '44', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('462', '6', '45', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('463', '6', '45', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('464', '6', '45', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('465', '6', '45', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('466', '6', '46', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('467', '6', '46', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('468', '6', '46', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('469', '6', '46', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('470', '6', '48', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('471', '6', '48', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('472', '6', '48', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('473', '6', '48', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('474', '6', '50', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('475', '6', '50', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('476', '6', '50', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('477', '6', '50', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('478', '6', '56', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('479', '6', '56', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('480', '6', '56', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('481', '6', '56', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('514', '7', '39', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('515', '7', '39', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('516', '7', '39', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('517', '7', '39', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('518', '7', '50', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('519', '7', '50', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('520', '7', '50', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('521', '7', '50', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('522', '7', '51', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('523', '7', '51', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('524', '7', '51', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('525', '7', '51', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('526', '7', '52', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('527', '7', '52', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('528', '7', '52', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('529', '7', '52', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('530', '7', '53', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('531', '7', '53', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('532', '7', '53', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('533', '7', '53', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('534', '7', '54', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('535', '7', '54', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('536', '7', '54', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('537', '7', '54', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('538', '7', '55', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('539', '7', '55', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('540', '7', '55', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('541', '7', '55', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('542', '7', '56', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('543', '7', '56', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('544', '7', '56', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('545', '7', '56', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('546', '8', '39', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('547', '8', '39', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('548', '8', '39', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('549', '8', '39', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('550', '8', '40', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('551', '8', '40', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('552', '8', '40', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('553', '8', '40', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('554', '8', '41', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('555', '8', '41', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('556', '8', '41', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('557', '8', '41', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('558', '8', '42', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('559', '8', '42', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('560', '8', '42', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('561', '8', '42', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('562', '8', '50', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('563', '8', '50', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('564', '8', '50', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('565', '8', '50', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('566', '8', '56', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('567', '8', '56', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('568', '8', '56', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('569', '8', '56', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('570', '9', '38', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('571', '9', '38', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('572', '9', '38', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('573', '9', '38', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('574', '9', '39', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('575', '9', '39', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('576', '9', '39', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('577', '9', '39', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('578', '9', '50', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('579', '9', '50', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('580', '9', '50', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('581', '9', '50', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('582', '9', '51', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('583', '9', '51', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('584', '9', '51', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('585', '9', '51', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('586', '9', '52', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('587', '9', '52', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('588', '9', '52', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('589', '9', '52', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('590', '9', '53', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('591', '9', '53', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('592', '9', '53', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('593', '9', '53', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('594', '9', '54', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('595', '9', '54', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('596', '9', '54', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('597', '9', '54', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('598', '9', '55', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('599', '9', '55', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('600', '9', '55', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('601', '9', '55', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('602', '9', '56', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('603', '9', '56', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('604', '9', '56', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('605', '9', '56', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('606', '7', '38', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('607', '7', '38', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('608', '7', '38', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('609', '7', '38', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('610', '6', '47', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('611', '6', '47', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('612', '6', '47', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('613', '6', '47', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('614', '4', '57', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('615', '4', '57', '2', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('616', '4', '57', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('617', '4', '57', '4', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('618', '11', '58', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('619', '10', '38', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('620', '10', '39', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('621', '10', '40', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('622', '10', '41', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('623', '10', '42', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('624', '10', '43', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('625', '10', '44', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('626', '10', '45', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('627', '10', '46', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('628', '10', '47', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('629', '10', '48', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('630', '10', '50', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('631', '10', '51', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('632', '10', '52', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('633', '10', '53', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('634', '10', '54', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('635', '10', '55', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('636', '10', '56', '1', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('637', '11', '59', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('638', '11', '60', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('639', '11', '61', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('640', '11', '62', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('643', '11', '65', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('644', '11', '66', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('645', '11', '67', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('646', '11', '68', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('647', '11', '69', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('648', '11', '70', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('649', '11', '63', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('651', '11', '64', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('652', '11', '71', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('653', '11', '72', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('654', '11', '73', '3', '1');
INSERT INTO `org_rol_modulo_permiso` VALUES ('655', '11', '74', '3', '1');

-- ----------------------------
-- Table structure for org_seccion
-- ----------------------------
DROP TABLE IF EXISTS `org_seccion`;
CREATE TABLE `org_seccion` (
  `id_seccion` int(50) NOT NULL AUTO_INCREMENT,
  `nombre_seccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `depende` int(50) NOT NULL,
  PRIMARY KEY (`id_seccion`),
  UNIQUE KEY `name` (`nombre_seccion`,`depende`),
  KEY `parentID` (`depende`)
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of org_seccion
-- ----------------------------
INSERT INTO `org_seccion` VALUES ('1', 'UNIDAD DE ASESORIA JURIDICA', '34');
INSERT INTO `org_seccion` VALUES ('2', 'LIQUIDACION LABORAL', '37');
INSERT INTO `org_seccion` VALUES ('3', 'ARCHIVO GENERAL', '36');
INSERT INTO `org_seccion` VALUES ('4', 'ADMINISTRACION DE PROYECTOS', '34');
INSERT INTO `org_seccion` VALUES ('5', 'CENTRO OBRERO COATEPEQUE', '36');
INSERT INTO `org_seccion` VALUES ('6', 'CENTRO OBRERO CONCHALIO', '36');
INSERT INTO `org_seccion` VALUES ('8', 'CENTRO OBRERO EL TAMARINDO', '36');
INSERT INTO `org_seccion` VALUES ('9', 'CENTRO OBRERO LA PALMA', '36');
INSERT INTO `org_seccion` VALUES ('10', 'CIUDAD MUJER', '61');
INSERT INTO `org_seccion` VALUES ('11', 'CLINICA EMPRESARIAL', '36');
INSERT INTO `org_seccion` VALUES ('12', 'CNR', '37');
INSERT INTO `org_seccion` VALUES ('13', 'CONSEJO NACIONAL DEL SALARIO MINIMO', '34');
INSERT INTO `org_seccion` VALUES ('14', 'CONSEJO SUPERIOR DEL TRABAJO', '34');
INSERT INTO `org_seccion` VALUES ('15', 'DEPARTAMENTO DE CENTROS DE RECREACION A TRABAJADORES', '36');
INSERT INTO `org_seccion` VALUES ('16', 'DEPARTAMENTO DE INSPECCION AGROPECUARIA', '37');
INSERT INTO `org_seccion` VALUES ('17', 'DEPARTAMENTO DE INSPECCION, INDUSTRIA, COMERCIO Y SERVICIO', '37');
INSERT INTO `org_seccion` VALUES ('18', 'DEPARTAMENTO DE INSPECCION AGROPECUARIA_NO USAR', '37');
INSERT INTO `org_seccion` VALUES ('19', 'DEPARTAMENTO DE RECURSOS HUMANOS', '36');
INSERT INTO `org_seccion` VALUES ('20', 'DEPARTAMENTO DE RELACIONES DE TRABAJO', '43');
INSERT INTO `org_seccion` VALUES ('21', 'DEPARTAMENTO DE SERVICIOS GENERALES', '36');
INSERT INTO `org_seccion` VALUES ('22', 'DEPARTAMENTO NACIONAL DE EMPLEO', '42');
INSERT INTO `org_seccion` VALUES ('23', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO DE APOPA', '42');
INSERT INTO `org_seccion` VALUES ('24', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO DE ILOPANGO', '42');
INSERT INTO `org_seccion` VALUES ('25', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO DE MEJICANOS', '42');
INSERT INTO `org_seccion` VALUES ('26', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO DE NEJAPA', '42');
INSERT INTO `org_seccion` VALUES ('27', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO DE SAN MARCOS', '42');
INSERT INTO `org_seccion` VALUES ('28', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO DE SOYAPANGO', '42');
INSERT INTO `org_seccion` VALUES ('29', 'DEPARTAMENTO DE EMPLEO BOLSA DE EMPLEO SAN MARTIN', '42');
INSERT INTO `org_seccion` VALUES ('30', 'DEPARTAMENTO NACIONAL DE ORGANIZACIONES SOCIALES', '43');
INSERT INTO `org_seccion` VALUES ('31', 'DEPARTAMENTO UACI', '36');
INSERT INTO `org_seccion` VALUES ('32', 'DEPTO DE INSPECCION AGRICOLA_NO USAR', '37');
INSERT INTO `org_seccion` VALUES ('33', 'DEPTO. DE SEGURIDAD E HIGIENE OCUPACIONAL', '42');
INSERT INTO `org_seccion` VALUES ('34', 'DESPACHO MINISTERIAL', '0');
INSERT INTO `org_seccion` VALUES ('35', 'DESPACHO VICE MINISTERIAL', '34');
INSERT INTO `org_seccion` VALUES ('36', 'DIRECCION ADMINISTRATIVA', '40');
INSERT INTO `org_seccion` VALUES ('37', 'DIRECCION GENERAL DE INSPECCION', '40');
INSERT INTO `org_seccion` VALUES ('39', 'DIRECCION DE RELACIONES INTERNACIONALES DE TRABAJO', '40');
INSERT INTO `org_seccion` VALUES ('40', 'DIRECCION EJECUTIVA', '34');
INSERT INTO `org_seccion` VALUES ('41', '117 TRABAJO', '0');
INSERT INTO `org_seccion` VALUES ('42', 'DIRECCION GENERAL DE PREVISION SOCIAL', '40');
INSERT INTO `org_seccion` VALUES ('43', 'DIRECCION GENERAL DE TRABAJO', '40');
INSERT INTO `org_seccion` VALUES ('44', 'INSPECCION SUPERVISORIA 3', '37');
INSERT INTO `org_seccion` VALUES ('46', 'EXTRANJERIA MIGRANTES', '42');
INSERT INTO `org_seccion` VALUES ('47', 'INFRAESTRUCTURA', '36');
INSERT INTO `org_seccion` VALUES ('48', 'INSPECCION AGROPECUARIA_NO USAR', '37');
INSERT INTO `org_seccion` VALUES ('49', 'INSPECCION SUPERVISORIA 2', '37');
INSERT INTO `org_seccion` VALUES ('51', 'MINISTRO', '34');
INSERT INTO `org_seccion` VALUES ('52', 'OFICINA DEPARTAMENTAL DE AHUACHAPAN', '35');
INSERT INTO `org_seccion` VALUES ('53', 'OFICINA DEPARTAMENTAL DE CABANAS', '35');
INSERT INTO `org_seccion` VALUES ('54', 'OFICINA DEPARTAMENTAL DE CHALATENANGO', '35');
INSERT INTO `org_seccion` VALUES ('55', 'OFICINA DEPARTAMENTAL DE CUSCATLAN', '35');
INSERT INTO `org_seccion` VALUES ('56', 'OFICINA DEPARTAMENTAL DE LA LIBERTAD', '35');
INSERT INTO `org_seccion` VALUES ('57', 'OFICINA DEPARTAMENTAL DE LA UNION', '35');
INSERT INTO `org_seccion` VALUES ('58', 'OFICINA DEPARTAMENTAL DE MORAZAN', '35');
INSERT INTO `org_seccion` VALUES ('59', 'OFICINA DEPARTAMENTAL DE SAN VICENTE', '35');
INSERT INTO `org_seccion` VALUES ('60', 'OFICINA DEPARTAMENTAL DE SONSONATE', '35');
INSERT INTO `org_seccion` VALUES ('61', 'OFICINA DEPARTAMENTAL DE USULUTAN', '35');
INSERT INTO `org_seccion` VALUES ('119', 'SECCION COORDINACION DE EMPLEO JUVENIL', '42');
INSERT INTO `org_seccion` VALUES ('64', 'OFICINA PARACENTRAL DE ZACATECOLUCA', '35');
INSERT INTO `org_seccion` VALUES ('65', 'OFICINA REGIONAL DE SAN MIGUEL', '35');
INSERT INTO `org_seccion` VALUES ('66', 'OFICINA REGIONAL DE SANTA ANA', '35');
INSERT INTO `org_seccion` VALUES ('67', 'PAGADURIA INSTITUCIONAL', '34');
INSERT INTO `org_seccion` VALUES ('68', 'RAC', '43');
INSERT INTO `org_seccion` VALUES ('69', 'SALA CUNA', '43');
INSERT INTO `org_seccion` VALUES ('72', 'SECCION DE BODEGA', '36');
INSERT INTO `org_seccion` VALUES ('73', 'SECCION DE COMPRAS', '36');
INSERT INTO `org_seccion` VALUES ('74', 'SECCION DE CONTABILIDAD', '34');
INSERT INTO `org_seccion` VALUES ('75', 'SECCION DE CORRESPONDENCIA', '34');
INSERT INTO `org_seccion` VALUES ('76', 'SECCION DE HIGIENE OCUPACIONAL', '42');
INSERT INTO `org_seccion` VALUES ('77', 'SECCION DE INTENDENCIA', '36');
INSERT INTO `org_seccion` VALUES ('78', 'SECCION DE MANTENIMIENTO', '36');
INSERT INTO `org_seccion` VALUES ('79', 'SECCION DE MULTAS', '37');
INSERT INTO `org_seccion` VALUES ('80', 'SECCION DE PRESUPUESTO', '34');
INSERT INTO `org_seccion` VALUES ('81', 'SECCION DE PREVENCION DE RIESGOS OCUPACIONALES', '42');
INSERT INTO `org_seccion` VALUES ('143', 'SECCION GENERAL', '36');
INSERT INTO `org_seccion` VALUES ('144', 'SECRETARIA DE DIRECCION GENERAL DE INSPECCION TRABAJO', '37');
INSERT INTO `org_seccion` VALUES ('140', 'SECCION GENERAL', '0');
INSERT INTO `org_seccion` VALUES ('84', 'SECCION DE RECREACION PARA TRABAJADORES', '36');
INSERT INTO `org_seccion` VALUES ('141', 'CAFETERIA', '36');
INSERT INTO `org_seccion` VALUES ('142', 'CORTE DE CUENTAS', '36');
INSERT INTO `org_seccion` VALUES ('86', 'SECCION DE REGLAMENTOS INTERNOS DE TRABAJO', '43');
INSERT INTO `org_seccion` VALUES ('87', 'SECCION DE RELACIONES COLECTIVAS DE TRABAJO', '43');
INSERT INTO `org_seccion` VALUES ('118', 'SECCION DE GRUPOS VULNERABLES', '42');
INSERT INTO `org_seccion` VALUES ('89', 'SECCION DE RELACIONES INDIVIDUALES DE TRABAJO', '43');
INSERT INTO `org_seccion` VALUES ('90', 'SECCION DE SEGURIDAD OCUPACIONAL', '42');
INSERT INTO `org_seccion` VALUES ('91', 'SECCION DE TRABAJADORES MIGRANTES', '42');
INSERT INTO `org_seccion` VALUES ('92', 'SECCION MULTAS', '37');
INSERT INTO `org_seccion` VALUES ('93', 'SECCION NOTIFICADORES DE INSPECCION', '37');
INSERT INTO `org_seccion` VALUES ('94', 'SECCION PRESUPUESTO', '34');
INSERT INTO `org_seccion` VALUES ('95', 'SECRETARIA DE DIRECCION GENERAL DE TRABAJO', '43');
INSERT INTO `org_seccion` VALUES ('97', 'INSPECCION SUPERVISORIA 1', '37');
INSERT INTO `org_seccion` VALUES ('98', 'SUB DIRECCION', '36');
INSERT INTO `org_seccion` VALUES ('99', 'SUB 36', '0');
INSERT INTO `org_seccion` VALUES ('100', 'UNIDAD DE ACCESO A LA INFORMACION PUBLICA', '34');
INSERT INTO `org_seccion` VALUES ('101', 'UNIDAD DE ACTIVO FIJO', '36');
INSERT INTO `org_seccion` VALUES ('104', 'UNIDAD DE ASESORIA LABORAL', '37');
INSERT INTO `org_seccion` VALUES ('105', 'UNIDAD DE ATENCION AL USUARIO', '36');
INSERT INTO `org_seccion` VALUES ('106', 'UNIDAD DE AUDITORIA Y CONTROL INTERNO', '34');
INSERT INTO `org_seccion` VALUES ('107', 'UNIDAD DE COORDINACION Y DESARROLLO INSTITUCIONAL', '40');
INSERT INTO `org_seccion` VALUES ('108', 'UNIDAD DE DESARROLLO TECNOLOGICO', '40');
INSERT INTO `org_seccion` VALUES ('109', 'UNIDAD DE ESTADISTICA E INFORMATICA LABORAL', '40');
INSERT INTO `org_seccion` VALUES ('120', 'UNIDAD DE ATENCION A ADOLESCENTES TRABAJADORES', '36');
INSERT INTO `org_seccion` VALUES ('111', 'UNIDAD DE NOTIFICADORES', '43');
INSERT INTO `org_seccion` VALUES ('112', 'UNIDAD DE PRENSA Y RELACIONES PUBLICAS', '40');
INSERT INTO `org_seccion` VALUES ('113', 'UNIDAD ESPECIAL DE GENERO Y PREV. ACTOS', '37');
INSERT INTO `org_seccion` VALUES ('114', 'UNIDAD ESPECIAL DE PREVENCION DE ACTOS LABORALES DISCRIMINATORIOS', '37');
INSERT INTO `org_seccion` VALUES ('115', 'UNIDAD FINANCIERA INSTITUCIONAL', '34');
INSERT INTO `org_seccion` VALUES ('116', 'UNIDAD PARA LA EQUIDAD ENTRE LOS GENEROS', '34');
INSERT INTO `org_seccion` VALUES ('117', 'UNIDAD DE ANALISIS E INVESTIGACION DEL MERCADO LABORAL', '42');
INSERT INTO `org_seccion` VALUES ('121', 'UNIDAD DE ADQUISICIONES Y CONTRATACIONES INSTITUCIONAL', '36');
INSERT INTO `org_seccion` VALUES ('122', 'INSPECCION SUPERVISORIA 4', '37');
INSERT INTO `org_seccion` VALUES ('123', 'RECEPCION DE SOLICITUD DE INSPECCION', '37');
INSERT INTO `org_seccion` VALUES ('124', 'SITRAMITPS', '0');
INSERT INTO `org_seccion` VALUES ('125', 'APELACIONES', '37');
INSERT INTO `org_seccion` VALUES ('126', 'INSCRIPCION DE ESTABLECIMIENTOS', '37');
INSERT INTO `org_seccion` VALUES ('127', 'COORDINACION DE INDUSTRIA DE COMERCIO', '37');
INSERT INTO `org_seccion` VALUES ('128', 'FERIAS DE EMPLEO', '22');
INSERT INTO `org_seccion` VALUES ('129', 'COORDINACION BOLSA DE EMPLEO LOCAL', '22');
INSERT INTO `org_seccion` VALUES ('130', 'SEMINTRAB', '0');
INSERT INTO `org_seccion` VALUES ('131', 'UNIDAD DE DIALOGO SOCIAL', '22');
INSERT INTO `org_seccion` VALUES ('132', 'SALA DE USOS MULTIPLES E4N2', '36');
INSERT INTO `org_seccion` VALUES ('133', 'SALA DE REUNION CONSEJO SUPERIOR DE TRABAJO', '14');
INSERT INTO `org_seccion` VALUES ('134', 'SALA DE REUNION CLINICA', '11');
INSERT INTO `org_seccion` VALUES ('135', 'SALA DE CAPACITACION RRHH', '19');
INSERT INTO `org_seccion` VALUES ('136', 'OFICINA DE LA PGR', '0');
INSERT INTO `org_seccion` VALUES ('137', 'ARCHIVO INSTITUCIONAL', '36');
INSERT INTO `org_seccion` VALUES ('138', 'SALA DE REUNION USOS MULTIPLES PREVISION DE RIESGOS', '42');
INSERT INTO `org_seccion` VALUES ('139', 'SALA DE REUNION CLINICA', '36');
INSERT INTO `org_seccion` VALUES ('145', 'UNIDAD DE ATENCION A NINOS Y NINAS ADOLESCENTES', '42');
INSERT INTO `org_seccion` VALUES ('146', 'UNIDAD DE APRENDICES', '42');

-- ----------------------------
-- Table structure for org_seccion_has_almacen
-- ----------------------------
DROP TABLE IF EXISTS `org_seccion_has_almacen`;
CREATE TABLE `org_seccion_has_almacen` (
  `id_seccion_has_almacen` int(10) NOT NULL AUTO_INCREMENT,
  `id_almacen` int(10) DEFAULT NULL,
  `id_seccion` int(10) DEFAULT NULL,
  `id_guarda` int(10) DEFAULT NULL,
  `id_actualiza` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_seccion_has_almacen`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_seccion_has_almacen
-- ----------------------------
INSERT INTO `org_seccion_has_almacen` VALUES ('1', '3', '36', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('2', '3', '115', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('3', '3', '72', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('4', '3', '121', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('5', '3', '104', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('6', '3', '116', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('7', '3', '15', '7', '7');
INSERT INTO `org_seccion_has_almacen` VALUES ('8', '3', '109', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('9', '3', '101', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('10', '3', '106', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('11', '3', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('12', '4', '40', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('13', '4', '1', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('14', '4', '34', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('15', '4', '39', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('16', '4', '35', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('17', '3', '100', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('18', '3', '98', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('19', '25', '21', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('20', '7', '19', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('21', '8', '11', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('22', '23', '3', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('23', '5', '128', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('24', '5', '13', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('25', '5', '129', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('26', '5', '118', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('27', '5', '130', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('28', '5', '22', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('29', '5', '14', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('30', '5', '47', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('31', '24', '137', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('32', '6', '36', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('33', '5', '115', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('34', '5', '15', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('35', '23', '101', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('36', '4', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('37', '1', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('38', '2', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('39', '5', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('40', '6', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('41', '8', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('42', '5', '34', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('43', '6', '35', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('44', '5', '77', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('45', '3', '19', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('46', '6', '19', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('47', '5', '109', '7', '7');
INSERT INTO `org_seccion_has_almacen` VALUES ('48', '8', '108', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('49', '5', '21', '7', '7');
INSERT INTO `org_seccion_has_almacen` VALUES ('51', '3', '21', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('52', '4', '21', '7', '7');
INSERT INTO `org_seccion_has_almacen` VALUES ('53', '1', '21', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('54', '2', '21', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('55', '6', '21', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('56', '7', '21', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('57', '3', '19', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('58', '6', '19', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('59', '5', '128', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('60', '5', '13', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('61', '5', '129', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('62', '5', '118', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('63', '5', '130', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('64', '5', '22', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('65', '5', '14', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('66', '5', '47', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('67', '6', '112', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('68', '3', '112', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('69', '6', '42', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('70', '6', '117', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('71', '6', '33', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('72', '6', '81', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('73', '6', '76', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('74', '6', '4', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('75', '6', '91', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('76', '6', '90', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('77', '1', '69', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('78', '1', '30', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('79', '1', '105', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('80', '1', '43', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('81', '1', '43', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('82', '1', '87', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('83', '1', '2', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('84', '1', '123', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('85', '1', '136', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('86', '1', '95', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('87', '1', '86', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('88', '5', '86', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('89', '1', '89', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('90', '1', '20', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('91', '5', '43', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('92', '2', '114', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('93', '2', '97', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('94', '2', '79', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('95', '2', '17', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('96', '2', '16', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('97', '6', '121', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('98', '2', '122', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('99', '2', '49', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('100', '2', '44', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('101', '2', '125', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('102', '2', '125', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('103', '2', '37', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('104', '2', '126', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('105', '2', '107', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('106', '1', '124', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('107', '3', '46', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('108', '12', '52', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('109', '14', '53', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('110', '13', '54', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('111', '16', '55', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('112', '15', '56', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('113', '22', '57', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('114', '21', '58', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('115', '20', '65', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('116', '17', '59', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('117', '10', '66', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('118', '11', '60', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('119', '19', '61', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('120', '18', '64', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('121', '26', '5', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('122', '27', '6', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('123', '28', '8', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('124', '29', '9', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('125', '9', '118', '7', '7');
INSERT INTO `org_seccion_has_almacen` VALUES ('126', '9', '128', '7', '7');
INSERT INTO `org_seccion_has_almacen` VALUES ('127', '9', '129', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('128', '30', '129', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('129', '1', '140', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('130', '2', '140', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('131', '3', '140', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('132', '4', '140', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('133', '5', '140', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('134', '6', '140', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('135', '9', '141', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('136', '24', '100', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('137', '8', '142', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('138', '31', '12', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('140', '32', '36', '7', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('141', '2', '144', '21', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('142', '5', '145', '21', null);
INSERT INTO `org_seccion_has_almacen` VALUES ('143', '5', '146', '21', null);

-- ----------------------------
-- Table structure for org_sistema
-- ----------------------------
DROP TABLE IF EXISTS `org_sistema`;
CREATE TABLE `org_sistema` (
  `id_sistema` int(50) NOT NULL AUTO_INCREMENT,
  `nombre_sistema` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_sistema`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_sistema
-- ----------------------------
INSERT INTO `org_sistema` VALUES ('1', 'SISTEMA INTEGRAL DE BODEGA');
INSERT INTO `org_sistema` VALUES ('2', 'SISTEMA DE ADMINISTRACION DE ROLES');
INSERT INTO `org_sistema` VALUES ('3', 'SISTEMA DE ACTIVO FIJO');
INSERT INTO `org_sistema` VALUES ('4', 'SISTEMA DE REGISTRO DE FICHAS DE EMPLEADOS DE RECURSOS HUMANOS');
INSERT INTO `org_sistema` VALUES ('5', 'SISTEMA DE TRANSPORTE, COMBUSTIBLE Y MANTENIMIENTO DE VEHICULOS');

-- ----------------------------
-- Table structure for org_solicitud_transporte
-- ----------------------------
DROP TABLE IF EXISTS `org_solicitud_transporte`;
CREATE TABLE `org_solicitud_transporte` (
  `id_solicitud_transporte` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hora_salida_mision` time NOT NULL,
  `hora_entrada_mision` time NOT NULL,
  `hora_salida_misionR` time DEFAULT NULL COMMENT 'hora salida Real',
  `hora_entrada_misionR` time DEFAULT NULL COMMENT 'hora entrada Real',
  `id_org_municipio` int(10) unsigned NOT NULL COMMENT 'llave foranea',
  `NR_empleado` varchar(45) NOT NULL COMMENT 'llave foranea con empleado',
  `fecha_solicitud` date NOT NULL,
  `NR_autorizado` tinyint(1) DEFAULT NULL COMMENT 'Si queda null no esta autorizado',
  `estado` tinyint(3) unsigned NOT NULL COMMENT 'estado de la mision',
  `lugar_destino` varchar(200) NOT NULL,
  `mision_encomendada` varchar(200) NOT NULL,
  `fecha_mision` date NOT NULL,
  `fecha_misionR` date DEFAULT NULL,
  PRIMARY KEY (`id_solicitud_transporte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_solicitud_transporte
-- ----------------------------

-- ----------------------------
-- Table structure for org_tipo_vehiculo
-- ----------------------------
DROP TABLE IF EXISTS `org_tipo_vehiculo`;
CREATE TABLE `org_tipo_vehiculo` (
  `id_tipo_vehiculo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_vehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of org_tipo_vehiculo
-- ----------------------------
INSERT INTO `org_tipo_vehiculo` VALUES ('1', 'Sedan');
INSERT INTO `org_tipo_vehiculo` VALUES ('2', 'Pick-Up');
INSERT INTO `org_tipo_vehiculo` VALUES ('3', 'Camioneta');
INSERT INTO `org_tipo_vehiculo` VALUES ('4', 'Pick 4x4');
INSERT INTO `org_tipo_vehiculo` VALUES ('5', 'Moto');
INSERT INTO `org_tipo_vehiculo` VALUES ('6', 'Microbus');

-- ----------------------------
-- Table structure for org_usuario
-- ----------------------------
DROP TABLE IF EXISTS `org_usuario`;
CREATE TABLE `org_usuario` (
  `id_usuario` int(50) NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(150) DEFAULT NULL,
  `nr` varchar(10) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `id_seccion` int(50) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_usuario
-- ----------------------------
INSERT INTO `org_usuario` VALUES ('1', 'EDUARDO CALDERON', '2654', 'M', 'eduardo.calderon', '7bb0217d8a73a8145290bc5fa5f36692', '2', '1');
INSERT INTO `org_usuario` VALUES ('2', 'HUGO RAMIREZ', '2478', 'M', 'hugo.ramirez', '827ccb0eea8a706c4c34a16891f84e7b', '2', '1');
INSERT INTO `org_usuario` VALUES ('3', 'SILVIA MORENO', '', 'F', 'silvia.moreno', '827ccb0eea8a706c4c34a16891f84e7b', '108', '1');
INSERT INTO `org_usuario` VALUES ('4', 'MARCO CASTRO', '888-C', 'M', 'marco.castro', '827ccb0eea8a706c4c34a16891f84e7b', '108', '1');
INSERT INTO `org_usuario` VALUES ('5', 'JESSICA MENJIVAR', '', 'F', 'jessica.menjivar', '827ccb0eea8a706c4c34a16891f84e7b', '2', '1');
INSERT INTO `org_usuario` VALUES ('6', 'CARLOS COTO', '2793', 'M', 'carlos.coto', '827ccb0eea8a706c4c34a16891f84e7b', '2', '1');
INSERT INTO `org_usuario` VALUES ('7', 'ELMER HERNANDEZ', null, 'M', 'elmer.hernandez', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');
INSERT INTO `org_usuario` VALUES ('8', 'IRIS LUNA', null, 'F', 'iris.luna', 'd28643a37c387267ce7594e32c177274', '101', '1');
INSERT INTO `org_usuario` VALUES ('9', 'MAURICIO ARNOLDO CALLEJAS', null, 'M', 'mauricio.callejas', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');
INSERT INTO `org_usuario` VALUES ('10', 'GIOVANI MIGUEL MENJIVAR', null, 'M', 'giovani.menjivar', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');
INSERT INTO `org_usuario` VALUES ('11', 'OQUELI CABRERA', null, 'M', 'oqueli.cabrera', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');
INSERT INTO `org_usuario` VALUES ('12', 'JOSE EVER VELASQUEZ', null, 'M', 'jose.velasquez', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');
INSERT INTO `org_usuario` VALUES ('13', 'BLANCA NOHEMI CAMPOS', '2681', 'F', 'blanca.campos', '070d3ebd85611641e2f9af0d2cb3a1a3', '19', '1');
INSERT INTO `org_usuario` VALUES ('14', 'ERICK ALEXANDER LARA', '2740', 'M', 'erick.lara', '070d3ebd85611641e2f9af0d2cb3a1a3', '19', '1');
INSERT INTO `org_usuario` VALUES ('15', 'PATRICIA AGUIÑADA', '2544', 'F', 'patricia.aguinada', '070d3ebd85611641e2f9af0d2cb3a1a3', '19', '1');
INSERT INTO `org_usuario` VALUES ('16', 'ISSA FUNES', 'NULL', 'F', 'issa.funes', '070d3ebd85611641e2f9af0d2cb3a1a3', '19', '1');
INSERT INTO `org_usuario` VALUES ('17', 'MANUEL REYES', '2668', 'M', 'manuel.reyes', '070d3ebd85611641e2f9af0d2cb3a1a3   ', '19', '1');
INSERT INTO `org_usuario` VALUES ('18', 'OSCAR RODRIGUEZ', null, 'M', 'oscar.rodriguez', '070d3ebd85611641e2f9af0d2cb3a1a3', '19', '1');
INSERT INTO `org_usuario` VALUES ('19', 'GUSTAVO DREISS', '2509', 'M', 'gustavo.dreiss', '070d3ebd85611641e2f9af0d2cb3a1a3', '19', '1');
INSERT INTO `org_usuario` VALUES ('20', 'ROBERTO HENRIQUEZ', '2588', 'M', 'roberto.henriquez', '827ccb0eea8a706c4c34a16891f84e7b', '108', '1');
INSERT INTO `org_usuario` VALUES ('21', 'USUARIO SAF', '0000', 'M', 'usuario.saf', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');
INSERT INTO `org_usuario` VALUES ('22', 'Leonel Adonis Peña Morán', '', 'M', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '101', '1');

-- ----------------------------
-- Table structure for org_usuario_rol
-- ----------------------------
DROP TABLE IF EXISTS `org_usuario_rol`;
CREATE TABLE `org_usuario_rol` (
  `id_usuario_rol` int(50) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(50) DEFAULT NULL,
  `id_rol` int(50) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of org_usuario_rol
-- ----------------------------
INSERT INTO `org_usuario_rol` VALUES ('1', '1', '1');
INSERT INTO `org_usuario_rol` VALUES ('2', '2', '1');
INSERT INTO `org_usuario_rol` VALUES ('3', '3', '2');
INSERT INTO `org_usuario_rol` VALUES ('4', '4', '3');
INSERT INTO `org_usuario_rol` VALUES ('5', '5', '1');
INSERT INTO `org_usuario_rol` VALUES ('6', '6', '1');
INSERT INTO `org_usuario_rol` VALUES ('7', '7', '4');
INSERT INTO `org_usuario_rol` VALUES ('8', '8', '4');
INSERT INTO `org_usuario_rol` VALUES ('9', '9', '5');
INSERT INTO `org_usuario_rol` VALUES ('10', '10', '5');
INSERT INTO `org_usuario_rol` VALUES ('11', '11', '5');
INSERT INTO `org_usuario_rol` VALUES ('12', '12', '5');
INSERT INTO `org_usuario_rol` VALUES ('13', '13', '7');
INSERT INTO `org_usuario_rol` VALUES ('14', '14', '6');
INSERT INTO `org_usuario_rol` VALUES ('15', '15', '8');
INSERT INTO `org_usuario_rol` VALUES ('16', '16', '10');
INSERT INTO `org_usuario_rol` VALUES ('17', '18', '7');
INSERT INTO `org_usuario_rol` VALUES ('18', '19', '8');
INSERT INTO `org_usuario_rol` VALUES ('19', '20', '10');
INSERT INTO `org_usuario_rol` VALUES ('20', '21', '5');
INSERT INTO `org_usuario_rol` VALUES ('21', '3', '5');
INSERT INTO `org_usuario_rol` VALUES ('22', '22', '11');

-- ----------------------------
-- Table structure for org_vehiculo
-- ----------------------------
DROP TABLE IF EXISTS `org_vehiculo`;
CREATE TABLE `org_vehiculo` (
  `placa` varchar(8) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `id_tipo_vehiculo` varchar(45) NOT NULL,
  `modelo` varchar(45) NOT NULL,
  `anio` decimal(10,0) NOT NULL,
  `id_session` int(10) unsigned NOT NULL,
  `condicion` varchar(30) NOT NULL,
  `unidad_asignacion` int(10) unsigned NOT NULL,
  `lugar_asignacion` varchar(45) NOT NULL,
  PRIMARY KEY (`placa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of org_vehiculo
-- ----------------------------
INSERT INTO `org_vehiculo` VALUES ('N-1234', 'Nissan', '5', 'Centra', '2004', '36', 'BUENO', '21', '1');
INSERT INTO `org_vehiculo` VALUES ('N-1242', 'Toyota', '4', 'Hillux', '2000', '36', 'REGULAR', '21', '1');

-- ----------------------------
-- Table structure for saf_bien
-- ----------------------------
DROP TABLE IF EXISTS `saf_bien`;
CREATE TABLE `saf_bien` (
  `id_bien` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del bien',
  `id_bien_dato_comun` int(10) DEFAULT NULL COMMENT 'Identificador único de los datos comunes del bien ',
  `serie_chasis` varchar(150) DEFAULT NULL COMMENT 'Número de serie de chasis del automovil',
  `numero_motor` varchar(150) DEFAULT NULL COMMENT 'Número de serie de motor del automovil',
  `numero_placa` varchar(150) DEFAULT NULL COMMENT 'Número de serie de placa del automovil',
  `matricula` varchar(150) DEFAULT NULL COMMENT 'Número de serie de matricula del automovil',
  `id_condicion` int(10) DEFAULT NULL COMMENT 'Identificador de la condición del bien',
  `observacion` varchar(250) DEFAULT NULL COMMENT 'Observaciones generales',
  `codigo` varchar(20) DEFAULT NULL COMMENT 'Código de inventario del bien',
  `correlativo` int(10) DEFAULT NULL COMMENT 'Número correlativo del bien respecto a su categoria',
  `codigo_anterior` varchar(20) DEFAULT NULL COMMENT 'Código de invenario anterior',
  `id_oficina` int(10) DEFAULT NULL COMMENT 'Identificador único de la oficina en la que se encuentra el bien',
  `id_empleado` int(10) DEFAULT NULL COMMENT 'Indentificador único del empleado a quien se ha asignado el bien',
  `id_tipo_inmueble` int(10) DEFAULT NULL COMMENT 'Identificador único de tipo de inmuble',
  `terreno_extension` varchar(20) DEFAULT NULL COMMENT 'Extensión del terreno',
  `terreno_direccion` varchar(500) DEFAULT NULL COMMENT 'Dirección del terreno',
  `terreno_zona` varchar(15) DEFAULT NULL COMMENT 'Definición de la zona en la que esta ubicado el terreno',
  `terreno_fines` varchar(500) DEFAULT NULL COMMENT 'Descripción de fines para los que fue adquirido el bien',
  `id_guarda` int(10) DEFAULT NULL COMMENT 'Identificador del último usuario que guarda',
  `id_actualiza` int(10) DEFAULT NULL COMMENT 'Identificador del último usuario que acualiza',
  PRIMARY KEY (`id_bien`),
  KEY `id_condicion` (`id_condicion`),
  KEY `id_bien_dato_comun` (`id_bien_dato_comun`),
  KEY `id_oficina` (`id_oficina`),
  KEY `id_tipo_inmueble` (`id_tipo_inmueble`),
  KEY `id_empleado` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of saf_bien
-- ----------------------------
