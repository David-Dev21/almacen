CREATE OR REPLACE VIEW vista_ingresos AS
SELECT
	i.id_ingreso, 
	p.nombre AS nombre_proveedor,
    u.name AS nombre_usuario,
    i.n_factura,
    i.n_pedido,
    i.fecha_hora, 
    i.estado,
    i.total
FROM 
    ingresos i
LEFT JOIN 
    proveedores p ON i.id_proveedor = p.id_proveedor
LEFT JOIN 
    users u ON i.id_usuario= u.id
ORDER BY 
    i.id_ingreso DESC;
    
CREATE OR REPLACE VIEW vista_salidas AS
SELECT 
    s.id_salida, 
    uni.nombre AS nombre_unidad,
    u.name AS nombre_usuario, 
    s.n_hoja_ruta,
    s.n_pedido,
    s.fecha_hora, 
    s.estado,
    s.total
FROM 
    salidas s
LEFT JOIN 
    unidades uni ON s.id_unidad = uni.id_unidad
LEFT JOIN 
    users u ON s.id_usuario = u.id
ORDER BY 
    s.id_salida DESC;


DELIMITER $$

CREATE OR REPLACE TRIGGER tr_ingresostock 
AFTER INSERT ON detalle_ingresos
FOR EACH ROW 
BEGIN
    -- Actualizar el stock sumando la cantidad original del detalle de ingreso
    UPDATE productos 
    SET stock = stock + NEW.cantidad_original
    WHERE id_producto = NEW.id_producto;
END $$

DELIMITER ;


DELIMITER $$

CREATE OR REPLACE TRIGGER tr_salidastock 
AFTER INSERT ON detalle_salidas
FOR EACH ROW 
BEGIN
    -- Actualizar el stock restando la cantidad del detalle de salida
    UPDATE productos 
    SET stock = stock - NEW.cantidad
    WHERE id_producto = NEW.id_producto;
END $$

DELIMITER ;

