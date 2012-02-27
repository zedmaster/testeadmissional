# SQL Manager 2007 for MySQL 4.5.0.4
# ---------------------------------------
# Host     : 10.9.0.201
# Port     : 3306
# Database : teste


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

SET FOREIGN_KEY_CHECKS=0;

#
# Structure for the `tb_cargo` table : 
#

CREATE TABLE `tb_cargo` (
  `pk_cargo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária do cargo.',
  `cargo` varchar(255) DEFAULT NULL COMMENT 'Nome do cargo.\r\nEx.: Analista, Programador, etc...',
  PRIMARY KEY (`pk_cargo`),
  UNIQUE KEY `pk_cargo` (`pk_cargo`),
  UNIQUE KEY `cargo` (`cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

#
# Structure for the `tb_usuario` table : 
#

CREATE TABLE `tb_usuario` (
  `pk_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária da tabela',
  `nome` varchar(255) NOT NULL COMMENT 'Nome completo do usuário.',
  `email` varchar(255) NOT NULL COMMENT 'Email do cliente.\r\nOs emails deverão ser únicos.',
  `cpf` varchar(11) NOT NULL COMMENT 'CPF sem pontos ou traços. Somente os dígitos.\r\nTotal de 11 caracteres.',
  `data_nascimento` varchar(10) NOT NULL COMMENT 'Data de nascimento do cliente.\r\nEx:. 22/12/1985',
  `data_inclusao` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de inclusão do registro na tabela.\r\nTIMESTAMP com default_current_timestamp.',
  `fk_cargo` int(11) NOT NULL COMMENT 'Chave estrangeria informando o cargo do usuário.',
  PRIMARY KEY (`pk_usuario`),
  UNIQUE KEY `pk_usuario` (`pk_usuario`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_cargo` (`fk_cargo`),
  CONSTRAINT `tb_usuario_fk` FOREIGN KEY (`fk_cargo`) REFERENCES `tb_cargo` (`pk_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

#
# Data for the `tb_cargo` table  (LIMIT 0,500)
#

INSERT INTO `tb_cargo` (`pk_cargo`, `cargo`) VALUES 
  (1,'Analista de Sistemas'),
  (2,'Programador'),
  (3,'Estagiário'),
  (4,'Suporte'),
  (5,'Gerente Comercial'),
  (6,'Coordenador'),
  (7,'Analista de Redes'),
  (8,'Analista de Suporte'),
  (9,'Analista de Teste'),
  (10,'Analista de Arquitetura'),
  (36,'Analista de Sistemas Jr'),
  (39,'Hibernate'),
  (43,'Cargo novo');
COMMIT;

#
# Data for the `tb_usuario` table  (LIMIT 0,500)
#

INSERT INTO `tb_usuario` (`pk_usuario`, `nome`, `email`, `cpf`, `data_nascimento`, `data_inclusao`, `fk_cargo`) VALUES 
  (1,'Usuário Um','usuario1@zednet.net.br','12345678912','20/01/1970','0000-00-00 00:00:00',9),
  (2,'Usuário Dois','usuario2@zednet.net.br','25124464432','12/02/1980','2010-08-27 16:49:41',9),
  (3,'Usuário Três','usuario3@zednet.net.br','859347596','16/08/1990','0000-00-00 00:00:00',39),
  (4,'Usuário Quatro','usuario4@zednet.net.br','156845963','15/08/1980','0000-00-00 00:00:00',36),
  (5,'Usuário Cinco','usuario5@zednet.net.br','45688686325','02/35/1980','2011-02-08 01:58:03',4),
  (6,'Usuário Seis','usuario6@zednet.net.br','35289789552','25/07/1980','0000-00-00 00:00:00',39);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
