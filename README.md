[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d5eaf75f-e9c9-4b79-bff6-75cee60c9e43/big.png)](https://insight.sensiolabs.com/projects/d5eaf75f-e9c9-4b79-bff6-75cee60c9e43)
# Personal Blog

This repository contains my personal blog for the realization of the Project 5 of the formation "Développeur d'application - PHP / Symfony" on Openclassroom.

## Requirements

For works this project require PHP7 and Composer.

## Installation

### With Git

You can use git and clone the repository on your folder.

```sh
cd /path/to/myfolder
git clone https://github.com/yanb94/blog.git
```  

### With Folder

You can download the repository at zip format and unzip it on your folder

### Install dependencies 

Install dependencies with composer.

```sh
composer update
```

### Virtual Host

For optimal working it is recommended to use a virtual host who are pointing on the folder web.

## Configuration 

For that project works it is necessary to configure the file blog/config/config.xml

**config.xml**
```xml
<?xml version="1.0" encoding="utf-8" ?>
<config>
	<!-- configuration of your database -->
	<database host="<YOUR HOST>" db="<DATABASE NAME>" user="<USER>" password="<PASSWORD>"/>
	<role_hierarchy>
		<role name="ROLE_ADMIN">
			<role_child name="ROLE_USER"></role_child>
		</role>
	</role_hierarchy>
	<twig>
		<paths>
			<path name="admin" value="/src/AdminModule/view"/>
			<path name="public" value="/src/PublicModule/view"/>
			<path name="core" value="/view"/>
		</paths>
	</twig>
	<info_user>
		<!-- email where you will receive the message from the contact form -->
		<email value="<YOUR EMAIL>"></email>
	</info_user>
</config>
```   

## Database 

For that project works you have to use those following tables 

```sql
CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `author` int(11) NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `author` int(11) NOT NULL,
  `article` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `civilite` varchar(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `confirmationToken` varchar(255) NOT NULL,
  `birthDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`),
  ADD KEY `article` (`article`);

ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`article`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
```
