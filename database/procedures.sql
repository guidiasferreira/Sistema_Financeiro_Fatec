use pi;

DELIMITER $$

CREATE FUNCTION fn_custo_total_fazenda(p_id_fazenda INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE v_custo_total DECIMAL(10,2);
    
    SELECT (tamanho_hec * custo_hec)
    INTO v_custo_total
    FROM fazenda
    WHERE id_fazenda = p_id_fazenda;
    
    RETURN v_custo_total;
END $$


CREATE FUNCTION fn_calcular_faturamento_fazenda(p_id_fazenda INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE v_receita DECIMAL(10,2);
    DECLARE v_receita_total DECIMAL(10,2);
    DECLARE tamanho_hec DECIMAL(10,2);

    SELECT SUM(p.valor_unitario * f.producao_hec), f.tamanho_hec
    INTO v_receita, tamanho_hec
    FROM fazenda f
    JOIN producao p ON p.id_fazenda = f.id_fazenda
    WHERE f.id_fazenda = p_id_fazenda;
    
    SET v_receita_total = v_receita * tamanho_hec;

    RETURN IFNULL(v_receita_total, 0);
END $$


CREATE FUNCTION fn_calcular_lucro_fazenda(p_id_fazenda INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE v_custo DECIMAL(10,2);
    DECLARE v_faturamento DECIMAL(10,2);
    DECLARE v_lucro DECIMAL(10,2);

    SET v_custo = fn_custo_total_fazenda(p_id_fazenda);
    SET v_faturamento = fn_calcular_faturamento_fazenda(p_id_fazenda);
    SET v_lucro = v_faturamento - v_custo;
    
    RETURN v_lucro;
END $$

DELIMITER ;


CREATE OR REPLACE VIEW vw_resumo_financeiro AS
SELECT 
    f.id_fazenda,
    f.id_proprietario,
    f.nome_fazenda,
    f.tamanho_hec,
    f.custo_hec,
    f.producao_hec,
    fn_custo_total_fazenda(f.id_fazenda) AS investimento_total,
    fn_calcular_faturamento_fazenda(f.id_fazenda) AS faturamento,
    fn_calcular_lucro_fazenda(f.id_fazenda) AS lucro,
    ROUND((fn_calcular_lucro_fazenda(f.id_fazenda) / fn_custo_total_fazenda(f.id_fazenda)) * 100, 1) AS ROI
FROM fazenda f;

CREATE OR REPLACE VIEW vw_resumo_geral AS
SELECT
	f.id_proprietario,
    SUM(fn_custo_total_fazenda(f.id_fazenda)) AS investimento_total,
    SUM(fn_calcular_faturamento_fazenda(f.id_fazenda)) AS faturamento_total,
    SUM(fn_calcular_lucro_fazenda(f.id_fazenda)) AS lucro_total,
    ROUND(AVG((fn_calcular_lucro_fazenda(f.id_fazenda) / fn_custo_total_fazenda(f.id_fazenda)) * 100), 1) AS roi_medio
FROM fazenda f
GROUP BY f.id_proprietario;
