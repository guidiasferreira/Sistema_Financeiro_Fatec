create database if not exists pi;
use pi;

create table if not exists proprietario (
	id_proprietario int not null primary key auto_increment,
    nome_proprietario varchar(150) not null,
    email_proprietario varchar(100) not null unique,
    senha varchar(255) not null
) engine = InnoDB;

create table if not exists fazenda (
	id_fazenda int not null primary key auto_increment,
    id_proprietario int not null,
    nome_fazenda varchar(150) not null,
    producao_hec decimal(10,2) not null,
    tamanho_hec decimal(10,2) not null,
    custo_hec decimal(10,2) not null, 
    
    constraint fk_fazenda_2_proprietario foreign key (id_proprietario) references proprietario(id_proprietario)
) engine = InnoDB;

create table if not exists cultura (
	id_cultura int not null primary key auto_increment,
    nome_cultura varchar(100) not null,
    valor_unitario decimal(10,2)
) engine = InnoDB;

create table if not exists producao (
	id_producao int not null primary key auto_increment,
    id_fazenda int not null,
    id_cultura int not null,
    valor_unitario decimal(10,2),
    
    constraint fk_producao_2_fazenda foreign key (id_fazenda) references fazenda(id_fazenda),
    constraint fk_producao_2_cultura foreign key (id_cultura) references cultura(id_cultura)
) engine = InnoDB;