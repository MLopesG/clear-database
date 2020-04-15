<!-- Código para uso interno -->
<!-- Limpeza de banco de dados, para possibilidar a migração há outro SGBD -->

<style type="text/css">

	*{
		font-family: 'Roboto Mono', monospace;
		background: black;
	}

	html{
		width: 80%;
		margin: 0 auto;
	}

	b{
		color: #fff;
		line-height: 1.5rem;
	}

	.true{
		color: #00B200;
	}

	.false{
		color: red;
	}

	h1{
		font-size: 1.4rem;
		color: white;
	}

</style>

<?php


// Conexão com banco de dados MYSQL

	$localhost = 'localhost';
	$dbname = 'dourasoft2';
	$user = 'root';
	$password = '';

// Script

try {
    $db = new PDO("mysql:host=$localhost;dbname=$dbname", $user, $password);
   
    // Excluir ForeignKey 

    $dropForeignKey = $db->query("
    	SELECT concat('ALTER TABLE ', CONSTRAINT_SCHEMA,'.',TABLE_NAME, ' DROP FOREIGN KEY ', CONSTRAINT_NAME, ';') 
    	FROM information_schema.key_column_usage 
    	WHERE REFERENCED_TABLE_NAME IS NOT NULL"
    );

	if(count($dropForeignKey->fetch()) > 0){
		echo "<h1>Excluindo relações entre tabelas</h1>";

		while ($drop = $dropForeignKey->fetch()) {
	    	if(!empty($drop)){
	    		if($db->query($drop[0])){
					echo '<b class="true">Executado: ' . $drop[0] . '</b><br>';
				}else{
					echo '<b class="false">Falhou: ' . $drop[0] .'</b><br>';
				}
	    	}
    	}
	}  

	// pausa

	sleep(3);

	// Drop tables

	$sqls = [
		"update sacado set ST_TELEFONE_SAC = REPLACE(ST_TELEFONE_SAC,'\"','')",
		"DROP TABLE edu_perfisavaliacoes",
		"DROP TABLE edu_periodosletivos",
		"DROP TABLE edu_planosmatrizes",
		"DROP TABLE edu_orientacoes",
		"DROP TABLE edu_matrizgruposdisciplinas",
		"DROP TABLE edu_modalidades",
		"DROP TABLE edu_niveisensino",
		"DROP TABLE edu_planospagamentos",
		"DROP TABLE edu_series",
		"DROP TABLE edu_statusmatriculasaulas",
		"DROP TABLE edu_tiposcoordenadores",
		"DROP TABLE edu_recursos",
		"DROP TABLE edu_producoescientificas",
		"DROP TABLE edu_professores",
		"DROP TABLE edu_racas",
		"DROP TABLE edu_formacoesacademicas",
		"DROP TABLE edu_habilitacoes",
		"DROP TABLE edu_instrumentosavaliacoes",
		"DROP TABLE edu_documentos",
		"DROP TABLE edu_disciplinas",
		"DROP TABLE edu_disciplinasautorizadas",
		"DROP TABLE edu_disciplinascoligadas",
		"DROP TABLE edu_matriculasaulas",
		"DROP TABLE edu_matrizeditais",
		"DROP TABLE edu_matrizes",
		"DROP TABLE edu_matrizesdisciplinas",
		"DROP TABLE edu_matriculascursosdocumentos",
		"DROP TABLE edu_matriculasaulasavaliacoes",
		"DROP TABLE edu_matriculasbolsas",
		"DROP TABLE edu_matriculascursos",
		"DROP TABLE condicoes_pagamento",
		"DROP TABLE condicoes_pagamento_regras",
		"DROP TABLE condominios",
		"DROP TABLE condominios_clientes",
		"DROP TABLE condominios_fornecedores",
		"DROP TABLE comissoes",
		"DROP TABLE centro_custo_contabil",
		"DROP TABLE certificado",
		"DROP TABLE cfops",
		"DROP TABLE cheques_pre",
		"DROP TABLE codigos_servicos",
		"DROP TABLE edu_cursos",
		"DROP TABLE edu_bolsas",
		"DROP TABLE edu_aulashorarios",
		"DROP TABLE edu_aulas",
		"DROP TABLE empresa",
		"DROP TABLE edu_turnos",
		"DROP TABLE edu_turmas",
		"DROP TABLE edu_cursoscoordenadores",
		"DROP TABLE edu_areas",
		"DROP TABLE contascontabeisignoradas",
		"DROP TABLE contabanco_mov_arquivos",
		"DROP TABLE contabanco_mov_agrupadas",
		"DROP TABLE contabanco_formapagamento",
		"DROP TABLE edu_alunos",
		"DROP TABLE ecommerce_conf",
		"DROP TABLE cupom_produtos",
		"DROP TABLE conta_contabil",
		"DROP TABLE favorecidos_tags_sequence",
		"DROP TABLE faturamento_compl_status",
		"DROP TABLE faturamento_compl",
		"DROP TABLE facilitador_credenciais",
		"DROP TABLE fila_de_emails",
		"DROP TABLE gen_bordero",
		"DROP TABLE fornecedores_arquivos",
		"DROP TABLE filiais",
		"DROP TABLE fila_push_mobile",
		"DROP TABLE extrato_cartao_registros",
		"DROP TABLE evento_contabil_impostos",
		"DROP TABLE evento_contabil",
		"DROP TABLE etiqueta_arquivos",
		"DROP TABLE encerramento_exercicio_contabil",
		"DROP TABLE evento_conta_categoria",
		"DROP TABLE extrato_cartao",
		"DROP TABLE exportacaocontabilitens",
		"DROP TABLE exportacaocontabil",
		"DROP TABLE evento_conta_contabil",
		"DROP TABLE lancamento_contabil",
		"DROP TABLE indiceatualizacaomonetaria",
		"DROP TABLE impressoras",
		"DROP TABLE lancamento_contabil_simples",
		"DROP TABLE log_contabil",
		"DROP TABLE logotipo",
		"DROP TABLE layout_exportacao",
		"DROP TABLE imposto_favorecido",
		"DROP TABLE historico_atendimento",
		"DROP TABLE grupo_centrocusto_relacionamento",
		"DROP TABLE grupo_centrocusto_contabil",
		"DROP TABLE historico_contabil",
		"DROP TABLE imposto",
		"DROP TABLE hydra_client_requests",
		"DROP TABLE historico_padrao",
		"DROP TABLE plano_contas_refreceita",
		"DROP TABLE plano_paramscallbacks",
		"DROP TABLE produtos_fornecedores",
		"DROP TABLE produtos_identificador",
		"DROP TABLE planilha_dados",
		"DROP TABLE planocontas",
		"DROP TABLE plano_centro_custo",
		"DROP TABLE plano_contas_contabil",
		"DROP TABLE produtos_tags_auxiliar",
		"DROP TABLE produto_variacao_opcoes",
		"DROP TABLE produto_variacoes",
		"DROP TABLE produto_variacoes_id",
		"DROP TABLE reajuste_indice",
		"DROP TABLE produtos_tags_identificador",
		"DROP TABLE produto_arquivos",
		"DROP TABLE produto_id_variacao_opcao",
		"DROP TABLE produto_variacao_opcao_id",
		"DROP TABLE modelos_html_sequence",
		"DROP TABLE mutex",
		"DROP TABLE nfe_lote",
		"DROP TABLE nota_adicionais",
		"DROP TABLE lote_rps",
		"DROP TABLE menu_extras",
		"DROP TABLE metricas_produtos",
		"DROP TABLE modelos",
		"DROP TABLE nota_erro",
		"DROP TABLE partida_evento",
		"DROP TABLE pedidos_identificador",
		"DROP TABLE planilha",
		"DROP TABLE planilha_colunas",
		"DROP TABLE ocorrencias",
		"DROP TABLE ocorrencias_modelo",
		"DROP TABLE orcamento",
		"DROP TABLE partida_contabil",
		"DROP TABLE template_html",
		"DROP TABLE testes_automaticos",
		"DROP TABLE ticket_arquivos",
		"DROP TABLE split",
		"DROP TABLE tags",
		"DROP TABLE tag_ocorrencias",
		"DROP TABLE webhooks",
		"DROP TABLE webhooks_processamentos",
		"DROP TABLE webhooks_queue",
		"DROP TABLE troca_senha",
		"DROP table caixa_usuarios",
		"DROP TABLE usuario_grupos",
		"DROP TABLE usuario_sequence",
		"DROP TABLE usuario_contas",
		"DROP TABLE usuario_configuracoes",
		"DROP TABLE series",
		"DROP TABLE relatorios_selecao",
		"DROP TABLE relatorios_selecao_envio",
		"DROP TABLE relatorio_conf",
		"DROP TABLE recebimento_informacoes",
		"DROP TABLE regras_tributacao",
		"DROP TABLE regratributacao_produto",
		"DROP TABLE sacado_enderecos",
		"DROP TABLE sacado_id_ecommerce",
		"DROP TABLE saldo_inicial_contabil",
		"DROP TABLE respostas_avaliacoes",
		"DROP TABLE resumo_pc",
		"DROP TABLE retorno_estornado",
		"DROP TABLE transferencia",
		"DROP TABLE token",
		"DROP TABLE ticket_historico",
		"DROP TABLE webhooks_detalhes_processamentos",
		"DROP TABLE versao",
		"DROP TABLE remessa",
		"DROP TABLE recebimento_sequence",
		"DROP TABLE recebimento_faixas",
		"DROP TABLE reajuste_tabelas",
		"DROP TABLE ticket",
		"DROP TABLE retorno_lote",
		"DROP TABLE retorno_itens",
		"DROP TABLE retorno",
		"DROP TABLE ofc",
		"DROP TABLE ofc_auto",
		"DROP TABLE ofc_registros",
		"DROP TABLE nota_produtos",
		"DROP TABLE modelos_padrao",
		"DROP TABLE municipio",
		"DROP TABLE nota",
		"DROP TABLE modelos_aplicacao",
		"DROP TABLE metricas_validacao",
		"DROP TABLE metricas",
		"DROP TABLE arquivos_ferramentas",
		"DROP TABLE auditoria_arquivo",
		"DROP TABLE arquivo_ini",
		"DROP TABLE avisos_leitura",
		"DROP TABLE carrinho_produtos",
		"DROP TABLE carrinhos",
		"DROP TABLE captcha_verificacoes",
		"DROP TABLE bandeiras",
		"DROP TABLE bancos",
		"DROP TABLE cenarios_tributacao",
		"DROP TABLE centro_custo",
		"DROP TABLE confirmacao_leitura",
		"DROP TABLE confirmacao_ativa",
		"DROP TABLE conciliacao_sugestoes",
		"DROP TABLE cupons_utilizados",
		"DROP TABLE cupons",
		"DROP TABLE contatos_token",
		"DROP TABLE contabanco_mov_cc",
		"DROP TABLE etiquetas",
		"DROP TABLE empresa_conf",
		"DROP TABLE fila_sms",
		"DROP TABLE fila_impressoes",
		"DROP TABLE feriados",
		"DROP TABLE grade_plano",
		"DROP TABLE gen_lote_notafiscal",
		"DROP TABLE funcionalidades",
		"DROP TABLE lotes_resultados",
		"DROP TABLE lotes",
		"DROP TABLE imagens",
		"DROP TABLE pedidos",
		"DROP TABLE pedido_endereco",
		"DROP TABLE plano_campos",
		"DROP TABLE sacados_vinculos",
		"DROP TABLE tipos_fretes",
		"DROP TABLE tipo_ocorrencia",
		"DROP TABLE tipo_periodicidade",
		"DROP TABLE tipos_documentos",
		"DROP TABLE plano_produtos_personalizados",
		"DROP TABLE plano_produtos",
		"DROP TABLE planos_grupos",
		"DROP TABLE contatos",
		"DROP TABLE bpocontabil_exportacao_itens",
		"DROP table bpocontabil_exportacao",
		"DROP table avaliacoes_pedidos",
		"DROP table auditoria_indice",
		"DROP table auditoria",
		"DROP table atualizacao_monetaria",
		"DROP table areas_complemento_tokens",
		"DROP table app_autoinstalar",
		"DROP table app",
		"DROP table administradora_cartoes",
		"DROP table acordo_item",
		"DROP table administradora",
		"DROP table acordo",
		"DROP table acessos",
		"DROP table acesso",
		"DROP table caixa_fechamentos",
		"DROP table caixa_transacao",
		"DROP table tipo_resultado_atendimento",
		"DROP table canais_token",
		"DROP table produtos_sequence",
		"DROP table produtos_tags",
		"DROP table produto_cc",
		"DROP table assinaturas_fidelizacoes",
		"DROP table arquivos",
		"DROP table cheque",
		"DROP table sacado_grupo",
		"DROP table grupo_cliente",
		"DROP table status_cliente",
		"DROP TABLE favorecidos_tags2",
		"DROP TABLE fornecedor_contatos",
		"DROP TABLE grupo_usuarios",
		"DROP TABLE usuario",
	"ALTER TABLE contabanco_mov
		DROP COLUMN FL_DESCONSIDERARCONTABILIDADE_MOV,
		DROP COLUMN FL_RECORRENTE_MOV,
		DROP COLUMN FL_RECORRENTEMANUAL_MOV,
		DROP COLUMN ID_TIPODESPESAPJBANK_MOV,
		DROP COLUMN ST_LABELREPASSE_MOV,
		DROP COLUMN ID_CONTABANCOMOVCONCILIADO_MOV,
		DROP COLUMN DT_CONCILIACAO_MOV,
		DROP COLUMN ID_OPERACAOSECURITIZADORA_MOV,
		DROP COLUMN ST_CODAUTENTICACAOPAG_MOV;",
	"ALTER TABLE contabanco_mov
		DROP COLUMN ST_OPERACAO_MOV,
		DROP COLUMN ID_OFC_OFC,
		DROP COLUMN ST_FITID_MOV,
		DROP COLUMN ID_PJ_MOV,
		DROP COLUMN DT_EXCLUSAO_MOV,
		DROP COLUMN ST_LABEL_MOV,
		DROP COLUMN ST_PAGAMENTOEXTERNO_MOV,
		DROP COLUMN DT_ALTERACAO_MOV,
		DROP COLUMN FL_STATUSEXTERNO_MOV;",
	"ALTER TABLE contabanco_mov
		DROP COLUMN ST_CODIGORECEITA_MOV,
		DROP COLUMN FL_TIPOTRIBUTO_MOV,
		DROP COLUMN ST_NOMECONTRIBUINTE_MOV,
		DROP COLUMN FL_TIPOCONTRIBUINTE_MOV,
		DROP COLUMN ST_IDENTCONTRIBUINTE_MOV,
		DROP COLUMN VL_OUTRASENTIDADES_MOV,
		DROP COLUMN VL_TRIBUTOMULTA_MOV,
		DROP COLUMN VL_TRIBUTOENCARGOS_MOV,
		DROP COLUMN DT_TRIBUTOPERIODO_MOV,
		DROP COLUMN ST_TRIBUTONUMEROREF_MOV,
		DROP COLUMN VL_TRIBUTORECEITABRUTA_MOV,
		DROP COLUMN ST_PORCENTORECEITABRUTA_MOV,
		DROP COLUMN ST_OBSERVACOES_MOV,
		DROP COLUMN ST_BANCO_MOV,
		DROP COLUMN ST_CONTA_MOV,
		DROP COLUMN ST_AGENCIABANCO_MOV,
		DROP COLUMN ST_NOMERECEBEDOR_MOV,
		DROP COLUMN ST_CNPJRECEBEDOR_MOV,
		DROP COLUMN FL_TIPOCONTA_MOV;",
	"ALTER TABLE contabanco_mov
		DROP COLUMN ID_RET_ORIGEM_MOV,
		DROP COLUMN ST_CODIGOBARRAS_MOV,
		DROP COLUMN ID_TIPO_DOC,
		DROP COLUMN ID_REMESSA_MOV,
		DROP COLUMN TX_REMESSAMSG_MOV,
		DROP COLUMN ST_ARQRET_MOV,
		DROP COLUMN ST_NFE_MOV,
		DROP COLUMN ID_PARCELAMENTO_MOV,
		DROP COLUMN FL_REPASSE_MOV,
		DROP COLUMN ID_RECEBIMENTO_RECB,
		DROP COLUMN FL_LANCAMENTOEXTERNO_MOV,
		DROP COLUMN ST_MSGRETORNO_MOV,
		DROP COLUMN FL_CARTAOINDEVIDO_MOV,
		DROP COLUMN ST_MD5ESTORNO_MOV,
		DROP COLUMN ST_SINCRO_MOV,
		DROP COLUMN ID_ORIGINAL_MOV,
		DROP COLUMN DT_COMPETENCIADESPESA_MOV;",
	"ALTER TABLE contabanco_mov
		DROP COLUMN ST_DOCUMENTO_MOV,
		DROP COLUMN VL_RET_VALORRETIDO_MOV,
		DROP COLUMN VL_RET_SUBEMPREITADA_MOV,
		DROP COLUMN VL_RET_MATERIAL_MOV,
		DROP COLUMN VL_RET_MAODEOBRA_MOV,
		DROP COLUMN VL_RET_TOTALNF_MOV,
		DROP COLUMN FL_VIRTUAL_MOV,
		DROP COLUMN ST_MD5PARCELA_MOV,
		DROP COLUMN ST_RET_ORIGEMMD5PARCELA_MOV,
		DROP COLUMN ID_ORIGEMVIRTUAL_MOV,
		DROP COLUMN DT_PERIODICIDADEINICIO_MOV,
		DROP COLUMN DT_PERIODICIDADEFIM_MOV;",
	"ALTER TABLE planos
	  DROP ST_EMAILCLIENTE_PLA,
	  DROP ST_EMAILEMPRESA_PLA;",
	"ALTER TABLE planos
	  DROP ST_TITULOEMAILCANCELCLI_PLA,
	  DROP ST_TITULOEMAILCANCELEMP_PLA,
	  DROP ST_EMAILCANCELCLI_PLA,
	  DROP ST_EMAILCANCELEMP_PLA,
	  DROP ST_TITULOEMAILTRIALCLI_PLA,
	  DROP ST_EMAILTRIALCLI_PLA,
	  DROP ST_TITULOEMAILTRIALEMP_PLA,
	  DROP ST_EMAILTRIALEMP_PLA,
	  DROP ST_TITULOEMAILRECONTRATO_PLA,
	  DROP ST_EMAILRECONTRATO_PLA,
	  DROP ST_EMAILLIBERACAOEMP_PLA,
	  DROP ST_TITULOEMAILLIBERACAOEMP_PLA,
	  DROP ST_TITULOEMAILMIGRACAOCLI_PLA,
	  DROP ST_EMAILMIGRACAOCLI_PLA,
	  DROP ST_TITULOEMAILMIGRACAOEMP_PLA,
	  DROP ST_EMAILMIGRACAOEMP_PLA,
	  DROP ST_TITULOEMAILMIGRALIBCLI_PLA,
	  DROP ST_EMAILMIGRALIBCLI_PLA,
	  DROP ST_TITULOEMAILMIGRALIBEMP_PLA,
	  DROP ST_EMAILMIGRALIBEMP_PLA,
	  DROP ST_TITULOEMAILFIMTRIALCLI_PLA,
	  DROP ST_EMAILFIMTRIALCLI_PLA,
	  DROP ST_TITULOEMAILFIMTRIALEMP_PLA,
	  DROP ST_EMAILFIMTRIALEMP_PLA;",
	"ALTER TABLE planos
	  DROP ST_TITULOEMAILEMPRESA_PLA,
	  DROP ST_TITULOEMAILCLIENTE_PLA,
	  DROP ST_TITULOEMAILLIBERACAO_PLA,
	  DROP ST_EMAILLIBERACAO_PLA;",
	"ALTER TABLE conta_banco
	  	DROP ST_USODOBANCO_CB,
		DROP ST_LOCALPAGAMENTO_CB,
		DROP ST_CAMPOEXTRA_CB,
		DROP NM_CNAB_CB,
		DROP NM_REMESSACARTEIRA_CB,
		DROP NM_TIPOPROTESTO_CB,
		DROP NM_DIAPROTESTO_CB,
		DROP NM_EMISSAO_CB,
		DROP NM_DISTRIBUICAO_CB,
		DROP DT_ALTERACAO_SINCRO,
		DROP FL_DESATIVAR_CB,
		DROP FL_FECHADA_CB,
		DROP ST_MD5_CB,
		DROP FL_GERARONLINE_CB,
		DROP ST_NOSSONUMERO_CB,
		DROP ST_CODEMPRESA_CB,
		DROP FL_VISA_CB,
		DROP ST_CODVISA_CB,
		DROP FL_PARCELASVISA_CB,
		DROP VL_SALDOINICIAL_CB,
		DROP DT_SALDOINICIAL_CB,
		DROP DT_SALDOFINAL_CB,
		DROP FL_USARFAIXANN_CB,
		DROP ST_PROXIMONN_CB,
		DROP ID_TIPOCONTABANCO_CB,
		DROP ST_NOMECEDENTE_CB,
		DROP FL_REMESSAINDISPONIBILIZAR_CB,
		DROP NM_REMESSAINDISPONIBI_DIAS_CB,
		DROP FL_HOMOLOGADO_CB,
		DROP FL_PRINCIPAL_CB,
		DROP ST_LAYOUT_CB,
		DROP FL_FRENTEDECAIXA_CB,
		DROP FL_COFRE_CB,
		DROP ID_FILIAL_FIL,
		DROP ST_IDENTIFICADOR_CB,
		DROP FL_HOMOLOGACAOREM_CB,
		DROP NM_CNABDEBITOAUT_CB,
		DROP ST_CONVENIODEB_CB,
		DROP ST_CONVENIOBANCO_CB,
		DROP ST_TOKEN_CB,
		DROP ST_CONTACONTABIL_CB,
		DROP NM_CNABPAGAMENTO_CB,
		DROP FL_ENVIAPCNOREMESSA_CB,
		DROP ST_SECRET_CB,
		DROP ST_TOKENCARTAO_CB,
		DROP ST_SEXOPORTADOR_CB,
		DROP ST_NOMEPORTADOR_CB,
		DROP DT_NASCIMENTOPORTADOR_CB,
		DROP NM_CARTAOPORTADOR_CB,
		DROP ST_URLCARGACARTAO_CB,
		DROP VL_SALDOMINIMOCARTAO_CB,
		DROP VL_RECARGAAUTOMATICACARTAO_CB,
		DROP DT_ULTIMACONCILIACAOCARTAO_CB,
		DROP ST_MD5ULTIMACARGACARTAO_CB,
		DROP ID_CONTABANCORECARGA_CD,
		DROP ST_CONVENIOBANCO2_CB,
		DROP ST_CONVENIOBANCO3_CB,
		DROP ST_ACCESSKEYPJ_CB,
		DROP ST_CPFPORTADOR_CB,
		DROP FL_CONTAWEBSERVICE_CB,
		DROP ST_EMAILPORTADOR_CB,
		DROP FL_EXTRATOBANCARIODIAPAGAMENTO_CB,
		DROP ST_CONVENIOSALARIO_CB,
		DROP DT_BLOQUEARLANCAMENTOS_CB,
		DROP ID_CONTACONTABIL_CTC;",
	"ALTER TABLE contas
	  DROP FL_NATUREZA_CONT,
	  DROP ID_PLANOCONTA_PLC,
	  DROP ST_CONTA_CONT,
	  DROP ST_ORDENACAO_CONT,
	  DROP ST_CONTACONTABIL_CONT,
	  DROP NM_CODREDUZIDO_CONT,
	  DROP ST_CONTACONTABILDESPESA_CONT,
	  DROP FL_APENASLANCAMENTOEXTERNO_CONT;",
	"ALTER TABLE forma_recebimento
	  DROP ST_GATEWAY_FRECB,
	  DROP ST_LOGIN_FRECB,
	  DROP ST_SENHA_FRECB,
	  DROP ID_CONTA_CB,
	  DROP NM_DIASCREDITO_FRECB,
	  DROP VL_TAXA_FRECB,
	  DROP FL_PRODUCAO_FRECB,
	  DROP FL_PRINCIPAL_FRECB,
	  DROP FL_VISA_FRECB,
	  DROP FL_MASTERCARD_FRECB,
	  DROP FL_DINERS_FRECB,
	  DROP FL_AMEX_FRECB,
	  DROP FL_ELO_FRECB,
	  DROP ST_CAMPOEXTRA1_FRECB,
	  DROP FL_BOLETOSUPERLOGICA_FRECB,
	  DROP FL_CREDITOUNICOPARCELADO_FRECB,
	  DROP FL_HIPERCARD_FRECB,
	  DROP FL_HIPER_FRECB,
	  DROP ST_NOMEFORMARECEBIMENTO_FRECB,
	  DROP ST_MSGOUTRASFORMAS_FRECB,
	  DROP VL_TAXAPARCELAMENTO_FRECB,
	  DROP NM_DIASCONVERCAO_FRECB,
	  DROP FL_BLOQUEARNOTIFICACAO_FRECB,
	  DROP ST_HTMLEXIBICAO_FRECB,
	  DROP FL_HOMOLOGACAOREM_FRECB,
	  DROP FL_USARFAIXANN_FRECB,
	  DROP FL_DESATIVAR_FRECB,
	  DROP NM_CNAB_FRECB,
	  DROP NM_CNABDEBITOAUT_FRECB,
	  DROP NM_CNABPAGAMENTO_FRECB,
	  DROP NM_REMESSACARTEIRA_FRECB,
	  DROP NM_REMESSAINDISPON_DIAS_FRECB,
	  DROP NM_DIAPROTESTO_FRECB,
	  DROP NM_TIPOPROTESTO_FRECB,
	  DROP NM_DISTRIBUICAO_FRECB,
	  DROP NM_EMISSAO_FRECB,
	  DROP ST_CARTEIRA_FRECB,
	  DROP ST_CODIGOACENTE_FRECB,
	  DROP ST_CODEMPRESA_FRECB,
	  DROP ST_CONVENIODEB_FRECB,
	  DROP ST_CONVENIOBANCO_FRECB,
	  DROP ST_ESPECIEDOC_FRECB,
	  DROP ST_LAYOUT_FRECB,
	  DROP ST_NOMECEDENTE_FRECB,
	  DROP ST_NOSSONUMERO_FRECB,
	  DROP ST_PROXIMONN_FRECB,
	  DROP ST_USODOBANCO_FRECB,
	  DROP ST_CAMPOEXTRA_FRECB,
	  DROP FL_CONVENIOANTIGO_FRECB,
	  DROP FL_REMESSAINDISPONIBIL_FRECB,
	  DROP FL_ENVIAPCNOREMESSA_FRECB,
	  DROP FL_STATUSCONTAPJBANK_FRECB;",
	"ALTER TABLE mensalidade
	  DROP FL_ONLINE_MENS,
	  DROP FL_JAN_MENS,
	  DROP FL_FEV_MENS,
	  DROP FL_MAR_MENS,
	  DROP FL_ABR_MENS,
	  DROP FL_MAI_MENS,
	  DROP FL_JUN_MENS,
	  DROP FL_JUL_MENS,
	  DROP FL_AGO_MENS,
	  DROP FL_SET_MENS,
	  DROP FL_OUT_MENS,
	  DROP FL_NOV_MENS,
	  DROP FL_DEZ_MENS,
	  DROP ST_COMPLEMENTO_MENS,
	  DROP ID_TABELA_RTA,
	  DROP NM_DIAVENCIMENTO_MENS,
	  DROP ID_FILIAL_FIL,
	  DROP ID_VENDEDOR_MENS,
	  DROP ST_LABEL_MENS,
	  DROP DT_IMPORTACAOFATURAMENTO_MENS,
	  DROP ID_ENDERECO_SEN,
	  DROP FL_ADICIONAL_MENS,
	  DROP ST_IDENTIFICADOR_MENS,
	  DROP FL_FIMFORCADO_MENS,
	  DROP VL_TXJUROS_MENS,
	  DROP VL_TXMULTA_MENS,
	  DROP VL_TXDESCONTO_MENS,
	  DROP DT_FIMANTIGO_MENS;",
	"ALTER TABLE produtos
	  DROP FL_INSIDEICMS_PRD,
	  DROP FL_DESATIVADO_PRD,
	  DROP ID_PLANOCONTA_PLC,
	  DROP ID_CODIGOSERVICO_CSE,
	  DROP FL_NAOTRIBUTAVEL_PRD,
	  DROP FL_NATUREZAOP_PRD,
	  DROP ST_CODIGOBARRASEAN_PRD,
	  DROP ST_NCM_PRD,
	  DROP ST_PESOLIQUIDO_PRD,
	  DROP ST_PESOBRUTO_PRD,
	  DROP NM_COMPRIMENTO_PRD,
	  DROP NM_LARGURA_PRD,
	  DROP NM_ALTURA_PRD,
	  DROP ST_OBSERVACAOEXTERNA_PRD,
	  DROP FL_DEDUZIRISSQN_PRD,
	  DROP FL_DEDUZIRINSS_PRD,
	  DROP FL_DEDUZIRIRRF_PRD,
	  DROP FL_DEDUZIRPIS_PRD,
	  DROP FL_DEDUZIRCOFINS_PRD,
	  DROP FL_DEDUZIRCSLL_PRD,
	  DROP ID_REGRATRIBUTACAO_RTB,
	  DROP VL_TRIBUTOSAPROX_PRD,
	  DROP VL_CUSTOUNITARIO_PRD,
	  DROP VL_PROMOCIONAL_PRD,
	  DROP FL_EMPROMOCAO_PRD,
	  DROP ID_TAG_TAG,
	  DROP ST_DESCRICAOCOMPLETA_PRD,
	  DROP ID_CONDICAOPAGAMENTO_CPG,
	  DROP FL_APLICARDESCONTO_PRD,
	  DROP FL_APLICARENCARGOS_PRD,
	  DROP FL_IMPORTADO_PRD,
	  DROP ST_CEST_PRD,
	  DROP ST_SCRIPTCARRINHO_PRD,
	  DROP ST_SCRIPTFINALIZADO_PRD,
	  DROP FL_DISPONIBILIZARVENDA_PRD,
	  DROP ST_CONTADESCONTO_CONT,
	  DROP ST_DESCRICAODESCONTO_CONT,
	  DROP ID_FORNECEDOR_FOR,
	  DROP NM_QTDMINIMA_PRD,
	  DROP NM_QTDMAXIMA_PRD,
	  DROP FL_NOTAFATURA_PRD,
	  DROP FL_SINCRONIZAR_PRD,
	  DROP ST_RESUMO_PRD,
	  DROP ST_URLVIDEO_PRD,
	  DROP NM_DIASPROCESSAMENTO_PRD,
	  DROP ST_SEOSLUG_PRD,
	  DROP ST_SEOTITLE_PRD,
	  DROP ST_SEODESCRIPTION_PRD,
	  DROP ST_SEOKEYWORDS_PRD,
	  DROP ST_SEOMETATAGS_PRD,
	  DROP NM_ESTOQUEATUAL_PRD,
	  DROP NM_ESTOQUEMINIMO_PRD,
	  DROP NM_ESTOQUEMAXIMO_PRD,
	  DROP DT_PROMOCAOINICIO_PRD,
	  DROP DT_PROMOCAOFIM_PRD,
	  DROP ID_PRODUTOPAI_PRD,
	  DROP FL_SINCRONIZARSEMPRE_PRD,
	  DROP FL_SINCRONIZARESTOQUE_PRD,
	  DROP FL_SINCRONIZARPRECO_PRD,
	  DROP VL_TRIBUTOSAPROXMUN_PRD,
	  DROP VL_TRIBUTOSAPROXEST_PRD,
	  DROP VL_TRIBUTOSAPROXFED_PRD,
	  DROP ST_LINKPOLITICA_PRD,
	  DROP ST_TEXTOURLPOLITICA_PRD,
	  DROP ST_UNIDADE_PRD,
	  DROP VL_ALIQICMS_PRD,
	  DROP VL_ALIQIPI_PRD,
	  DROP VL_BASEICMS_PRD,
      DROP ST_CLFISCAL_PRD,
	  DROP ST_SISTTRIB_PRD;",
	"ALTER TABLE planos_clientes
	  DROP FL_TRIAL_PLC,
	  DROP DT_TRIALFIM_PLC,
	  DROP DT_TRIALINICIO_PLC,
	  DROP FL_AUTOCONTRATAR_PLC,
	  DROP ID_VENDEDOR_FOR,
	  DROP ST_EMAILINDICACAO_PLC,
	  DROP ST_NOME_CUP,
	  DROP ST_IDENTIFICADOREXTRA_PLC,
	  DROP FL_AUTORECONTRATAR_PLC,
	  DROP NM_PARCELASADESAO_PLC,
	  DROP VL_APROXRENOVACAO_PLC,
	  DROP VL_DESCONTORENOVACAO_PLC,
	  DROP ID_PROXIMARENOVACAO_RECB,
	  DROP DT_ULTIMARENOVACAO_RECB,
	  DROP NM_DIASGRATIS_PLC,
	  DROP ID_ENDERECO_SEN,
	  DROP FL_NOVOCONTRATO_PLC,
	  DROP FL_TIPOCANCELAMENTO_PLC,
	  DROP NM_ADIAMENTOFIMTRIAL_PLC,
	  DROP FL_PRIMEIROPAG_PLC,
	  DROP ID_TICKET_TIC,
	  DROP FL_DIFERENCACANCELAMENTO_PLC,
	  DROP FL_PRIMEIROPAGNOTIFICADO_PLC,
	  DROP DT_PRIMEIROPAG_PLC,
	  DROP ST_OBSERVACAO_PLC,
	  DROP ST_FRETE_PLC,
	  DROP ID_PLANOCLIENTEORIGEM_PLC,
	  DROP FL_TRIALDESATIVADO_PLC,
	  DROP FL_METRICAINICIAL_PLC,
	  DROP ID_TRIALORIGEM_PLC,
	  DROP FL_ALTERARMETRICA_PLC,
	  DROP FL_CONVERSAOTRIAL_PLC,
	  DROP DT_CANCELAMENTOANTIGO_PLC,
	  DROP FL_AUTORECONTRATARANTIGO_PLC,
	  DROP NM_PARCELASRECORRENCIA_PLC,
	  DROP FL_PERIODICIDADE_PLC;",
	"ALTER TABLE recebimento
	  DROP ST_MD5_RECB,
	  DROP DT_IMPRESSAO_RECB,
	  DROP DT_ALTERACAO_SINCRO,
	  DROP VL_TXMULTA_RECB,
	  DROP VL_TXJUROS_RECB,
	  DROP FL_PRORATADIA_RECB,
	  DROP FL_COMPOSICAO_RECB,
	  DROP DT_ACORDO_RECB,
	  DROP NM_REMESSA_RECB,
	  DROP FL_REMESSASTATUS_RECB,
	  DROP TX_REMESSAMSG_RECB,
	  DROP FL_IMPORTACAO_RECB,
	  DROP ID_NOTA_NOT,
	  DROP ST_INSTRUCOES_RECB,
	  DROP FL_ONLINE_RECB,
	  DROP ID_ONLINE_RECB,
	  DROP NM_IMPRESSOES_RECB,
	  DROP ST_OBSERVACAOINTERNA_RECB,
	  DROP FL_NOSSONUMEROFIXO_RECB,
	  DROP ST_DOCUMENTOEX_RECB,
	  DROP FL_PROTESTADO_RECB,
	  DROP TX_CARTAOMENSAGEM_RECB,
	  DROP ST_LABEL_RECB,
	  DROP VL_TXDESCONTO_RECB,
	  DROP ST_NF_RECB,
	  DROP ST_OBSERVACAOEXTERNA_RECB,
	  DROP ST_CIELOTID_RECB,
	  DROP FL_CIELOFORCARPAGAMENTO_RECB,
	  DROP DT_CIELOULTIMATENTATIVA_RECB,
	  DROP ID_CHEQUE_PRE,
	  DROP ID_FECHAMENTO_CFE,
	  DROP ID_USUARIO_USU,
	  DROP ST_MAQUINA_RECB,
	  DROP ID_TRANSACAO_CTR,
	  DROP ID_BANDEIRA_BAN,
	  DROP DT_PREVISAOCREDITO_RECB,
	  DROP ID_ADMCARTOES_ADC,
	  DROP DT_FECHAMENTO_CFE,
	  DROP ST_LABEL2_RECB,
	  DROP FL_PRIMEIRANOTIFICACAO_RECB,
	  DROP FL_SEGUNDANOTIFICACAO_RECB,
	  DROP FL_TERCEIRANOTIFICACAO_RECB,
	  DROP FL_ACORDOFRENTEDECAIXA_RECB,
	  DROP NM_VISTO_RECB,
	  DROP ST_NUMEROAUTORIZACAO_RECB,
	  DROP ID_LOTE_RECB,
	  DROP ID_FILIAL_FIL,
	  DROP ST_LABEL3_RECB,
	  DROP FL_PRIMEIRANOTIFICACAOSMS_RECB,
	  DROP FL_SEGUNDANOTIFICACAOSMS_RECB,
	  DROP FL_PRIMEIRANOTIFICACAOCART_RECB,
	  DROP FL_SEGUNDANOTIFICACAOCARTA_RECB,
	  DROP ST_CARTAODETALHES_RECB,
	  DROP FL_TEMCOMISSAO_RECB,
	  DROP ID_FORMA_FRECB,
	  DROP ST_LABEL_MENS,
	  DROP DT_CARTAOTRANSACAO_RECB,
	  DROP ST_ERROCARTAO_RECB,
	  DROP FL_CONVERTERPARANOTA_RECB,
	  DROP ID_ADESAO_PLC,
	  DROP ID_RENOVACAO_PLC,
	  DROP ST_COMPLEMENTOCOMPOSICAO_RECB,
	  DROP ST_TOKENFACILITADOR_RECB,
	  DROP ST_TOKENDACONTA_RECB,
	  DROP ST_CIELOTIDCANCELAMENTO_RECB,
	  DROP VL_TAXACOBRANCA_RECB,
	  DROP ST_HASHPARCELAMENTO_RECB,
	  DROP ST_CARTAOBANDEIRA_RECB,
	  DROP FL_DESPESASVINCULADAS_RECB,
	  DROP FL_QUARTANOTIFICACAO_RECB,
	  DROP ST_TIDCONCILIACAO_RECB,
	  DROP ID_ENDERECO_SEN,
	  DROP FL_MOTIVOCANCELAR_RECB,
	  DROP ST_IDEXTERNO_RECB,
	  DROP FL_CONSULTARTIDTARDIO_RECB,
	  DROP FL_IGNORARBLOQUEIOAUTO_RECB,
	  DROP ST_NUMEROCARTAO_RECB,
	  DROP NM_PARCELACARTAO_RECB,
	  DROP FL_CONCILIADO_RECB,
	  DROP FL_TIPOENTREGA_RECB,
	  DROP ST_CODMOVIMENTACAOREM_RECB,
	  DROP ID_CONTAORIGEM_RECB,
	  DROP FL_CONTRATOPRORROGADO_RECB,
	  DROP ST_MARCADOR_RECB,
	  DROP ID_FORMABOLETO_FRECB,
	  DROP ST_HASHEMAILPAG_RECB,
	  DROP ST_ACCESSKEYCR_RECB,
	  DROP FL_REMESSASTATUSCR_RECB,
	  DROP NM_TENTATIVASENVIOCR_RECB,
	  DROP FL_QUINTANOTIFICACAO_RECB,
	  DROP FL_SEXTANOTIFICACAO_RECB,
	  DROP FL_TERCEIRANOTIFICACAOSMS_RECB,
	  DROP NM_DESCONTOATEDIA_RECB,
	  DROP FL_TXDESCONTOPERSONALIZADA_RECB,
	  DROP ID_RECEBIMENTOANTIGO_RECB,
	  DROP VL_DESCONTOCALCULADO_RECB,
	  DROP ST_SPLITDADOS_RECB,
	  DROP FL_GERACAONOTIFICADA_RECB,
	  DROP NM_VERSAORECEBIMENTO_RECB,
	  DROP NM_VERSAORECEBIMENTOPJBANK_RECB,
	  DROP ST_MOTIVOCANCELOUTROS_RECB,
	  DROP DT_ALTERACAO_RECB,
	  DROP FL_DESCONSIDERARCONTABILIDADE_RECB,
	  DROP ID_PARTIDACONTABIL_PC,
	  DROP ID_PARTIDACONTABILLIQUIDACAO_PC,
	  DROP ID_PARTIDACONTABILBAIXA_PC,
	  DROP DT_VENCIMENTOORIGINAL_RECB,
	  DROP DT_PEDIDOREGISTROPJBANK_RECB,
	  DROP DT_PEDIDOBAIXAPJBANK_RECB,
	  DROP ID_OPERACAOSECURITIZADORA_RECB,
	  DROP FL_STATUSSECURITIZADORA_RECB;",
	];

	echo "<h1>Excluindo tabelas que não são necessárias.</h1>";

	foreach ($sqls as $key => $sql) {
		if($db->query($sql)){
			echo '<b class="true"> Executado: ' . $sql . '</b><br>';
		}else{
			echo '<b class="false"> Falhou: ' . $sql .'</b><br>';
		}
	}

	// Fechando conexão com banco de dados

	$db = null;

} catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}

