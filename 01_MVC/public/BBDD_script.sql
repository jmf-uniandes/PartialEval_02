-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema BBDD_RE
-- -----------------------------------------------------
-- Base de datos para gestionar reservas de eventos
-- 

-- -----------------------------------------------------
-- Schema BBDD_RE
--
-- Base de datos para gestionar reservas de eventos
-- 
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `BBDD_RE` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
-- -----------------------------------------------------
-- Schema sexto
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sexto
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sexto` DEFAULT CHARACTER SET utf8 ;
USE `BBDD_RE` ;

-- -----------------------------------------------------
-- Table `BBDD_RE`.`events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BBDD_RE`.`events` (
  `idEvents` INT NOT NULL AUTO_INCREMENT,
  `event_name` TEXT NOT NULL,
  `event_description` TEXT NOT NULL,
  `event_date` DATETIME NOT NULL,
  `event_location` VARCHAR(45) NOT NULL,
  `event_status` INT NOT NULL COMMENT '0=Available\n1=Reserved\n',
  PRIMARY KEY (`idEvents`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BBDD_RE`.`clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BBDD_RE`.`clients` (
  `idClients` INT NOT NULL AUTO_INCREMENT,
  `client_name` VARCHAR(45) NOT NULL,
  `client_surename` VARCHAR(45) NOT NULL,
  `client_email` VARCHAR(45) NOT NULL,
  `client_phonenumber` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idClients`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BBDD_RE`.`reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BBDD_RE`.`reservations` (
  `idReservations` INT NOT NULL AUTO_INCREMENT,
  `events_idEvents` INT NOT NULL,
  `clients_idClients` INT NOT NULL,
  `reservationStatus` INT NULL,
  PRIMARY KEY (`idReservations`),
  INDEX `fk_reservations_events_idx` (`events_idEvents` ASC) ,
  INDEX `fk_reservations_clients1_idx` (`clients_idClients` ASC) ,
  CONSTRAINT `fk_reservations_events`
    FOREIGN KEY (`events_idEvents`)
    REFERENCES `BBDD_RE`.`events` (`idEvents`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservations_clients1`
    FOREIGN KEY (`clients_idClients`)
    REFERENCES `BBDD_RE`.`clients` (`idClients`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BBDD_RE`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BBDD_RE`.`roles` (
  `idRoles` INT NOT NULL AUTO_INCREMENT,
  `roles_description` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRoles`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BBDD_RE`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BBDD_RE`.`users` (
  `idUsers` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NOT NULL,
  `user_password` VARCHAR(45) NOT NULL,
  `user_status` INT NOT NULL COMMENT '0=Disable\n1=Active',
  `roles_idRoles` INT NOT NULL,
  PRIMARY KEY (`idUsers`),
  INDEX `fk_users_roles1_idx` (`roles_idRoles` ASC) ,
  CONSTRAINT `fk_users_roles1`
    FOREIGN KEY (`roles_idRoles`)
    REFERENCES `BBDD_RE`.`roles` (`idRoles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `sexto` ;

-- -----------------------------------------------------
-- Table `sexto`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`clientes` (
  `idClientes` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombres` TEXT NOT NULL,
  `Direccion` TEXT NOT NULL,
  `Telefono` VARCHAR(45) NOT NULL,
  `Cedula` VARCHAR(13) NOT NULL,
  `Correo` TEXT NOT NULL,
  PRIMARY KEY (`idClientes`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`factura` (
  `idFactura` INT(11) NOT NULL AUTO_INCREMENT,
  `Fecha` DATETIME NOT NULL,
  `Sub_total` DECIMAL(10,0) NOT NULL,
  `Sub_total_iva` DECIMAL(10,0) NOT NULL,
  `Valor_IVA` DECIMAL(10,0) NOT NULL,
  `Clientes_idClientes` INT(11) NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_Factura_Clientes1_idx` (`Clientes_idClientes` ASC) ,
  CONSTRAINT `fk_Factura_Clientes1`
    FOREIGN KEY (`Clientes_idClientes`)
    REFERENCES `sexto`.`clientes` (`idClientes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`iva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`iva` (
  `idIVA` INT(11) NOT NULL AUTO_INCREMENT,
  `Detalle` VARCHAR(45) NOT NULL COMMENT '8%\\n12%\\n15%',
  `Estado` INT(11) NOT NULL COMMENT '1 = activo\\n0 = inactivo',
  `Valor` INT(11) NULL DEFAULT NULL COMMENT 'Campo para almacenar el valor en entero para realizar calculos',
  PRIMARY KEY (`idIVA`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`productos` (
  `idProductos` INT(11) NOT NULL AUTO_INCREMENT,
  `Codigo_Barras` TEXT NULL DEFAULT NULL,
  `Nombre_Producto` TEXT NOT NULL,
  `Graba_IVA` INT(11) NOT NULL COMMENT 'Campo para almacenar si el producto graba IVA o no\\n1 = Graba IVA\\n0 = No posee IVA',
  PRIMARY KEY (`idProductos`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`proveedores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`proveedores` (
  `idProveedores` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Empresa` VARCHAR(45) NOT NULL,
  `Direccion` TEXT NULL DEFAULT NULL,
  `Telefono` VARCHAR(17) NOT NULL,
  `Contacto_Empresa` VARCHAR(45) NOT NULL COMMENT 'Campo para almacenar el nombre del empleado de la empresa para contactarse',
  `Teleofno_Contacto` VARCHAR(17) NOT NULL COMMENT 'Campo para almacenar el numero de telefono del coantacto de la emprsa',
  PRIMARY KEY (`idProveedores`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`unidad_medida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`unidad_medida` (
  `idUnidad_Medida` INT(11) NOT NULL AUTO_INCREMENT,
  `Detalle` TEXT NULL DEFAULT NULL,
  `Tipo` INT(11) NULL DEFAULT NULL COMMENT '1 = Unidad de Medida Ej: Gramos, Litros, Kilos\\n0 = Presentacion Ej: Caja, Unidad, Docena, Sixpack\\n2 = Factor de Conversion Ej: Kilos a libras',
  PRIMARY KEY (`idUnidad_Medida`))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`kardex`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`kardex` (
  `idKardex` INT(11) NOT NULL AUTO_INCREMENT,
  `Estado` INT(11) NOT NULL COMMENT 'Campo para almacenar el estado del kardex\\n1 = activo\\n0 = inactivo',
  `Fecha_Transaccion` DATETIME NOT NULL,
  `Cantidad` VARCHAR(45) NOT NULL,
  `Valor_Compra` DECIMAL(10,0) NOT NULL,
  `Valor_Venta` DECIMAL(10,0) NOT NULL,
  `Unidad_Medida_idUnidad_Medida` INT(11) NOT NULL,
  `Unidad_Medida_idUnidad_Medida1` INT(11) NOT NULL,
  `Unidad_Medida_idUnidad_Medida2` INT(11) NOT NULL,
  `Valor_Ganacia` DECIMAL(10,0) NULL DEFAULT NULL,
  `IVA` INT(11) NOT NULL,
  `IVA_idIVA` INT(11) NOT NULL,
  `Proveedores_idProveedores` INT(11) NOT NULL,
  `Productos_idProductos` INT(11) NOT NULL,
  `Tipo_Transaccion` INT(11) NOT NULL COMMENT '1= entrada Ej: Compra\\n0 = salida  Ej: Venta',
  PRIMARY KEY (`idKardex`),
  INDEX `fk_Kardex_Unidad_Medida_idx` (`Unidad_Medida_idUnidad_Medida` ASC) ,
  INDEX `fk_Kardex_Unidad_Medida1_idx` (`Unidad_Medida_idUnidad_Medida1` ASC) ,
  INDEX `fk_Kardex_Unidad_Medida2_idx` (`Unidad_Medida_idUnidad_Medida2` ASC) ,
  INDEX `fk_Kardex_IVA1_idx` (`IVA_idIVA` ASC) ,
  INDEX `fk_Kardex_Proveedores1_idx` (`Proveedores_idProveedores` ASC) ,
  INDEX `fk_Kardex_Productos1_idx` (`Productos_idProductos` ASC) ,
  CONSTRAINT `fk_Kardex_IVA1`
    FOREIGN KEY (`IVA_idIVA`)
    REFERENCES `sexto`.`iva` (`idIVA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_Productos1`
    FOREIGN KEY (`Productos_idProductos`)
    REFERENCES `sexto`.`productos` (`idProductos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_Proveedores1`
    FOREIGN KEY (`Proveedores_idProveedores`)
    REFERENCES `sexto`.`proveedores` (`idProveedores`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_Unidad_Medida`
    FOREIGN KEY (`Unidad_Medida_idUnidad_Medida`)
    REFERENCES `sexto`.`unidad_medida` (`idUnidad_Medida`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_Unidad_Medida1`
    FOREIGN KEY (`Unidad_Medida_idUnidad_Medida1`)
    REFERENCES `sexto`.`unidad_medida` (`idUnidad_Medida`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_Unidad_Medida2`
    FOREIGN KEY (`Unidad_Medida_idUnidad_Medida2`)
    REFERENCES `sexto`.`unidad_medida` (`idUnidad_Medida`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`detalle_factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`detalle_factura` (
  `idDetalle_Factura` INT(11) NOT NULL AUTO_INCREMENT,
  `Cantidad` VARCHAR(45) NOT NULL,
  `Factura_idFactura` INT(11) NOT NULL,
  `Kardex_idKardex` INT(11) NOT NULL,
  `Precio_Unitario` DECIMAL(10,0) NOT NULL,
  `Sub_Total_item` DECIMAL(10,0) NOT NULL,
  PRIMARY KEY (`idDetalle_Factura`),
  INDEX `fk_Detalle_Factura_Factura1_idx` (`Factura_idFactura` ASC) ,
  INDEX `fk_Detalle_Factura_Kardex1_idx` (`Kardex_idKardex` ASC) ,
  CONSTRAINT `fk_Detalle_Factura_Factura1`
    FOREIGN KEY (`Factura_idFactura`)
    REFERENCES `sexto`.`factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Detalle_Factura_Kardex1`
    FOREIGN KEY (`Kardex_idKardex`)
    REFERENCES `sexto`.`kardex` (`idKardex`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`roles` (
  `idRoles` INT(11) NOT NULL AUTO_INCREMENT,
  `Detalle` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRoles`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sexto`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sexto`.`usuarios` (
  `idUsuarios` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Usuario` VARCHAR(45) NOT NULL,
  `Contrasenia` VARCHAR(45) NOT NULL,
  `Estado` INT(11) NOT NULL,
  `Usuarioscol` VARCHAR(45) NULL DEFAULT NULL,
  `Roles_idRoles` INT(11) NOT NULL,
  PRIMARY KEY (`idUsuarios`),
  INDEX `fk_Usuarios_Roles_idx` (`Roles_idRoles` ASC) ,
  CONSTRAINT `fk_Usuarios_Roles`
    FOREIGN KEY (`Roles_idRoles`)
    REFERENCES `sexto`.`roles` (`idRoles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
