O que é o PDO; 
R: O PDO é a extensão de acesso a banco de dados mais utilizado na linguagem de programação PHP. 

Para que ele é utilizado no PHP;
R: O PDO é uma extensão da linguagem PHP para acesso a banco de dados. Totalmente orientado a objetos, ele possui diversos recursos importantes, além de suporte a diversos mecanismos de banco de dados. 

Como funciona uma conexão utilizando PDO;
R: Uma conexão utilizando PDO funciona por meio da instanciação da classe nativa PDO, que cria uma camada de abstração para comunicar o PHP com diferentes bancos de dados usando uma interface única. 

Quais são suas principais características;
R: 
1. O PDO (PHP Data Objects) é uma extensão do PHP que fornece uma interface leve e consistente para acesso a bancos de dados relacional.
2. Oferece um conjunto único de classes e métodos para consultar e coletar dados, independentemente do banco de dados utilizado. 

Vantagens e desvantagens de utilizar PDO;
R: Vantagens: Possui uma API limpa, moderna e consistente baseada em objetos 
Desvantagens: O PDO não reescreve sintaxes específicas de cada banco; se você mudar de SGBD, comandos com dialetos exclusivos precisarão ser reescritos manualmente. 

O que são Prepared Statements e por que são importantes;
R: são modelos de código SQL pré-compilados e armazenados pelo banco de dados, que recebem apenas parâmetros variáveis em cada execução. 
Em quais situações o PDO pode ser uma boa escolha.
R: Quando você está desenvolvendo aplicações em PHP que precisam interagir com bancos de dados relacionais e exigem segurança, flexibilidade e manutenção.


Fontes: 
https://www.treinaweb.com.br/blog/o-que-e-pdo-no-php
https://www.php.net/manual/pt_BR/pdo.connections.php
https://www.locaweb.com.br/ajuda/wiki/tudo-sobre-o-php-data-object-pdo-hospedagem-de-sites/
https://blog.grancursosonline.com.br/php-pdo-vs-mysqli/
