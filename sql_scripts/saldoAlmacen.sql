DELIMITER $$

CREATE OR REPLACE PROCEDURE ObtenerSaldoPorLotes(
    IN categoria_id INT,
    IN fecha_fin DATE
)
BEGIN
    SELECT 
		c.codigo as codigo_categoria,
        c.descripcion AS categoria,
        p.codigo AS codigo_producto,
        p.descripcion AS producto,
        p.unidad,
        di.lote,
        di.cantidad_original - COALESCE(SUM(ds.cantidad), 0) AS cantidad_actual,
        di.costo_u,
        (di.cantidad_original - COALESCE(SUM(ds.cantidad), 0)) * di.costo_u AS costo_total_lote
    FROM Categorias c
    INNER JOIN Productos p ON c.id_categoria = p.id_categoria
    INNER JOIN detalle_ingresos di ON p.id_producto = di.id_producto
    LEFT JOIN detalle_salidas ds ON di.id_producto = ds.id_producto AND di.lote = ds.lote
    LEFT JOIN Ingresos i ON di.id_ingreso = i.id_ingreso
    LEFT JOIN Salidas s ON ds.id_salida = s.id_salida
    WHERE (categoria_id IS NULL OR c.id_categoria = categoria_id)
    AND (fecha_fin IS NULL OR i.fecha_hora IS NULL OR DATE(i.fecha_hora) <= fecha_fin)
    AND (fecha_fin IS NULL OR s.fecha_hora IS NULL OR DATE(s.fecha_hora) <= fecha_fin)
    GROUP BY c.descripcion, p.codigo, p.descripcion, di.lote, di.cantidad_original, di.costo_u
    ORDER BY c.descripcion, p.descripcion, di.lote;
END $$

DELIMITER ;

DELIMITER $$

CREATE OR REPLACE PROCEDURE ObtenerTotalesPorProducto(
    IN categoria_id INT,
    IN fecha_fin DATE
)
BEGIN
    SELECT 
        p.codigo AS codigo_producto,
        p.descripcion AS producto,
        SUM(di.cantidad_original - COALESCE(ds.cantidad, 0)) AS total_cantidad_actual,
        SUM((di.cantidad_original - COALESCE(ds.cantidad, 0)) * di.costo_u) AS total_valor_actual
    FROM Categorias c
    INNER JOIN Productos p ON c.id_categoria = p.id_categoria
    INNER JOIN detalle_ingresos di ON p.id_producto = di.id_producto
    LEFT JOIN (
        SELECT id_producto, lote, SUM(cantidad) AS cantidad
        FROM detalle_salidas
        GROUP BY id_producto, lote
    ) ds ON di.id_producto = ds.id_producto AND di.lote = ds.lote
    LEFT JOIN Ingresos i ON di.id_ingreso = i.id_ingreso
    WHERE (categoria_id IS NULL OR c.id_categoria = categoria_id)
    AND (fecha_fin IS NULL OR i.fecha_hora IS NULL OR DATE(i.fecha_hora) <= fecha_fin)
    GROUP BY p.codigo, p.descripcion
    ORDER BY p.descripcion;
END $$

DELIMITER ;


DELIMITER $$

CREATE OR REPLACE PROCEDURE ObtenerTotalesPorCategoria(
    IN categoria_id INT,
    IN fecha_fin DATE
)
BEGIN
    -- Totales por categoría con WITH ROLLUP
    SELECT 
		c.codigo AS codigo_categoria,
        c.descripcion AS categoria,
        SUM(di.cantidad_original - COALESCE(ds.cantidad, 0)) AS total_cantidad_actual,
        SUM((di.cantidad_original - COALESCE(ds.cantidad, 0)) * di.costo_u) AS total_valor_actual
    FROM Categorias c
    INNER JOIN Productos p ON c.id_categoria = p.id_categoria
    INNER JOIN detalle_ingresos di ON p.id_producto = di.id_producto
    LEFT JOIN (
        SELECT ds.id_producto, ds.lote, SUM(ds.cantidad) AS cantidad
        FROM detalle_salidas ds
        GROUP BY ds.id_producto, ds.lote
    ) ds ON di.id_producto = ds.id_producto AND di.lote = ds.lote
    LEFT JOIN Ingresos i ON di.id_ingreso = i.id_ingreso
    WHERE (categoria_id IS NULL OR c.id_categoria = categoria_id)
    AND (fecha_fin IS NULL OR i.fecha_hora IS NULL OR DATE(i.fecha_hora) <= fecha_fin)
    GROUP BY c.descripcion WITH ROLLUP;
END $$

DELIMITER ;


-- Sin filtrar por categoría
CALL ObtenerSaldoPorLotes(NULL, '2025-02-27');
CALL ObtenerTotalesPorProducto(NULL, '2025-02-27');
CALL ObtenerTotalesPorCategoria(NULL, '2025-02-27');

