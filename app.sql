use istishara;


CREATE Table admin (
    id INT(11) AUTO_INCREMENT Not NULL,
    email VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,


    CONSTRAINT primary_key_id PRIMARY KEY (id),
    CONSTRAINT unique_email UNIQUE (email)
);


CREATE Table client ( 
    id INT(11) AUTO_INCREMENT Not NULL,
    email VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,


    CONSTRAINT primary_key_id PRIMARY KEY (id),
    CONSTRAINT unique_email UNIQUE (email)
);
CREATE TABLE villes (
    id INT(11) AUTO_INCREMENT Not NULL,
    name VARCHAR(255) NOT NULL,
    region VARCHAR(255) NOT NULL,
    code_postale VARCHAR(255) NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT primary_key_id PRIMARY KEY (id),
    CONSTRAINT unique_name UNIQUE (name)
);


create Table avocats ( 
    id INT(11) AUTO_INCREMENT Not NULL,
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT(11) NOT NULL,
    sexe ENUM("male", "female") NOT NULL,
    annes_experience INT(11) NOT NULL,
    specialite ENUM("civil", "famile", "droit penal") NOT NULL,
    consult_en_ligne ENUM("yes", "no") NOT NULL DEFAULT "no",
   
    ville_id INT(11) NOT NULL,


    CONSTRAINT primary_key_id PRIMARY KEY (id),
    CONSTRAINT unique_email UNIQUE (email),
    CONSTRAINT fk_ville_id_avocat FOREIGN KEY (ville_id) REFERENCES villes (id)
);

create Table huissiers (
     id INT(11) AUTO_INCREMENT Not NULL,
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT(11) NOT NULL,
    sexe ENUM("male", "female") NOT NULL,
    annes_experience INT(11) NOT NULL,

    type_actes ENUM("signification", "exécution", "constats") NOT NULL,

    ville_id INT(11) NOT NULL,


    CONSTRAINT primary_key_id PRIMARY KEY (id),
    CONSTRAINT unique_email UNIQUE (email),
    CONSTRAINT fk_ville_id_huiss FOREIGN KEY (ville_id) REFERENCES villes (id)

);