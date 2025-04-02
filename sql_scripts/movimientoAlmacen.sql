DELIMITER $$

CREATE OR REPLACE PROCEDURE obtenerMovimientos(
    IN fecha_inicio DATE,
    IN fecha_fin DATE
)
BEGIN
    -- Obtención de los movimientos de ingresos y salidas
    WITH Movimientos AS (
        -- Ingresos dentro del rango de fechas
        SELECT 
            di.id_producto, 
            di.lote, 
            DATE(i.fecha_hora) AS Fecha_Movimiento, 
            'Ingreso' AS tipo, 
            di.cantidad_original AS cantidad, 
            di.costo_u
        FROM detalle_ingresos di
        JOIN ingresos i ON di.id_ingreso = i.id_ingreso
        WHERE DATE(i.fecha_hora) BETWEEN fecha_inicio AND fecha_fin

        UNION ALL

        -- Salidas dentro del rango de fechas
        SELECT 
            ds.id_producto, 
            ds.lote, 
            DATE(s.fecha_hora) AS Fecha_Movimiento, 
            'Salida' AS tipo, 
            ds.cantidad, 
            ds.costo_u
        FROM detalle_salidas ds
        JOIN salidas s ON ds.id_salida = s.id_salida
        WHERE DATE(s.fecha_hora) BETWEEN fecha_inicio AND fecha_fin
    ),
    -- Cálculo del saldo inicial
    SaldoInicial AS (
        SELECT 
            di.id_producto, 
            di.lote,
            -- Saldo inicial: cantidad original menos salidas previas a la fecha de inicio
            COALESCE(di.cantidad_original, 0) - 
            COALESCE(SUM(CASE WHEN s.fecha_hora < fecha_inicio THEN ds.cantidad ELSE 0 END), 0) AS saldo_inicial,
            -- Costo inicial: costo unitario multiplicado por cantidad original menos costos de salidas previas
            COALESCE(di.cantidad_original * di.costo_u, 0) - 
            COALESCE(SUM(CASE WHEN s.fecha_hora < fecha_inicio THEN ds.cantidad * ds.costo_u ELSE 0 END), 0) AS costo_inicial
        FROM detalle_ingresos di
        JOIN ingresos i ON di.id_ingreso = i.id_ingreso
        LEFT JOIN detalle_salidas ds ON di.id_producto = ds.id_producto AND di.lote = ds.lote
        LEFT JOIN salidas s ON ds.id_salida = s.id_salida
        WHERE i.fecha_hora < fecha_inicio -- Fecha de corte para ingresos
        GROUP BY di.id_producto, di.lote
    )
    -- Consulta principal: Resultados detallados por producto y lote
    SELECT 
        p.codigo AS Codigo,
        p.descripcion AS Producto,
        COALESCE(si.lote, m.lote) AS Lote,
        COALESCE(m.Fecha_Movimiento, '') AS Fecha_Movimiento,
        COALESCE(si.saldo_inicial, 0) AS Saldo_Inicial,
        COALESCE(si.costo_inicial, 0) AS Costo_Inicial,
        SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad ELSE 0 END) AS Ingresos_Cantidad,
        SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad * m.costo_u ELSE 0 END) AS Ingresos_Costo,
        SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad ELSE 0 END) AS Salidas_Cantidad,
        SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad * m.costo_u ELSE 0 END) AS Salidas_Costo,
        (COALESCE(si.saldo_inicial, 0) + 
         SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad ELSE 0 END) - 
         SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad ELSE 0 END)) AS Saldo_Final,
        (COALESCE(si.costo_inicial, 0) + 
         SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad * m.costo_u ELSE 0 END) - 
         SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad * m.costo_u ELSE 0 END)) AS Costo_Final
    FROM productos p
    LEFT JOIN SaldoInicial si ON p.id_producto = si.id_producto
    LEFT JOIN Movimientos m ON p.id_producto = m.id_producto
    WHERE 
        -- Mostrar productos con saldo inicial o movimientos dentro del rango
        EXISTS (
            SELECT 1
            FROM SaldoInicial si2
            WHERE si2.id_producto = p.id_producto
        )
        OR EXISTS (
            SELECT 1
            FROM Movimientos m2
            WHERE m2.id_producto = p.id_producto
        )
    GROUP BY p.codigo, p.descripcion, COALESCE(si.lote, m.lote)

    UNION ALL

    -- Total general
    SELECT 
        'TOTAL' AS Codigo,
        'Total General' AS Producto,
        NULL AS Lote,
        NULL AS Fecha_Movimiento,
        SUM(COALESCE(si.saldo_inicial, 0)) AS Saldo_Inicial,
        SUM(COALESCE(si.costo_inicial, 0)) AS Costo_Inicial,
        SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad ELSE 0 END) AS Ingresos_Cantidad,
        SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad * m.costo_u ELSE 0 END) AS Ingresos_Costo,
        SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad ELSE 0 END) AS Salidas_Cantidad,
        SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad * m.costo_u ELSE 0 END) AS Salidas_Costo,
        (SUM(COALESCE(si.saldo_inicial, 0)) + 
         SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad ELSE 0 END) - 
         SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad ELSE 0 END)) AS Saldo_Final,
        (SUM(COALESCE(si.costo_inicial, 0)) + 
         SUM(CASE WHEN m.tipo = 'Ingreso' THEN m.cantidad * m.costo_u ELSE 0 END) - 
         SUM(CASE WHEN m.tipo = 'Salida' THEN m.cantidad * m.costo_u ELSE 0 END)) AS Costo_Final
    FROM productos p
    LEFT JOIN SaldoInicial si ON p.id_producto = si.id_producto
    LEFT JOIN Movimientos m ON p.id_producto = m.id_producto;

END $$

DELIMITER ;

-- Llamada al procedimiento
CALL obtenerMovimientos('2025-02-01', '2025-02-28');