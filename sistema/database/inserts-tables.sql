use pi;

insert pi.proprietario (nome_proprietario, email_proprietario, senha) 
						values ("Bassani Games", "bassanilegend1@gmail.com", "@bassani312"),
							   ("Vinas Games", "vinas@gmail.com", "@vinas312"),
							   ("Pezzoti Games", "pezzoti@gmail.com", "@pezzoti312"),
                               ("Gui Games", "gui@gmail.com", "@gui312");
                                                                            
insert pi.fazenda (id_proprietario, nome_fazenda, producao_hec, tamanho_hec, custo_hec) 
				  values (1, "Fazenda Carrinhos", 1000.0, 200.0, 32000.5),
						 (2, "Fazenda Souls", 280.0, 200.0, 30000.0),
                         (3, "Fazenda Filhos", 285.0, 200.0, 32000.5),
                         (4, "Fazenda CLI", 290.0, 200.0, 35000.0);
                                                                                                
insert pi.produto (nome_produto, valor_unitario) 	
				  values ("Canabis", 32.0),
						 ("Abacate", 107.15),
						 ("Pêssego", 112.0),
						 ("Caqui", 120);
                                                            
insert pi.producao (id_fazenda, id_produto) 
				    values (1, 1),
						   (2, 2),
                           (3, 3),
                           (4, 4);