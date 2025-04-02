DELIMITER $$

CREATE OR REPLACE PROCEDURE detalle_salidas_con_categorias(IN id_salida INT)
BEGIN
    -- Consulta para obtener los detalles de salidas con categorías filtrados por id_salida
    SELECT 
        p.codigo AS codigo_producto,
        p.descripcion AS producto,
        c.codigo AS codigo_categoria,
        c.descripcion AS categoria,
        p.unidad,
        d.cantidad,
        d.costo_u,
        d.lote,
        d.id_salida 
    FROM detalle_salidas AS d
    INNER JOIN productos AS p 
        ON d.id_producto = p.id_producto
    INNER JOIN categorias AS c 
        ON p.id_categoria = c.id_categoria
    WHERE d.id_salida = id_salida;
END$$

DELIMITER ;


DELIMITER $$

CREATE OR REPLACE PROCEDURE detalle_ingresos_con_categorias(IN id_ingreso INT)
BEGIN
    SELECT 
        p.codigo AS codigo_producto,
        p.descripcion AS producto,
        c.codigo AS codigo_categoria,
        c.descripcion AS categoria,
        p.unidad,
        d.cantidad_original,
        d.cantidad_disponible,
        d.costo_u,
        d.lote,
        d.id_ingreso 
    FROM detalle_ingresos AS d
    INNER JOIN productos AS p 
        ON d.id_producto = p.id_producto
    INNER JOIN categorias AS c 
        ON p.id_categoria = c.id_categoria
    WHERE d.id_ingreso = id_ingreso;
END$$

DELIMITER ;



