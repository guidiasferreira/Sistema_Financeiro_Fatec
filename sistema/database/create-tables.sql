create database if not exists pi;
use pi;

create table if not exists proprietario (
	id_proprietario int not null primary key auto_increment,
    nome_proprietario varchar(150) not null,
    email_proprietario varchar(100) not null,
    senha varchar(28) not null

) engine = InnoDB;

create table if not exists fazenda (
	id_fazenda int not null primary key auto_increment,
    id_proprietario int not null,
    nome_fazenda varchar(150) not null,
    producao_hec decimal(10,2),
    tamanho_hec decimal(10,2),
    custo_hec decimal(10,2),
    
    constraint fk_fazenda_2_proprietario foreign key (id_proprietario) references proprietario(id_proprietario)

) engine = InnoDB;

create table if not exists produto (
	id_produto int not null primary key auto_increment,
    nome_produto varchar(100) not null,
    valor_unitario decimal(10,2)

) engine = InnoDB;

create table if not exists producao (
	id_producao int not null primary key auto_increment,
    id_fazenda int not null,
    id_produto int not null,
    
    constraint fk_producao_fazenda foreign key (id_fazenda) references fazenda(id_fazenda),
    constraint fk_producao_produto foreign key (id_produto) references produto(id_produto)
    
) engine = InnoDB;