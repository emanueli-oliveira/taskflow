CREATE TABLE projects (
    id_projects SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    description TEXT,
    status  VARCHAR(20) DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    user_id INTEGER references users(id_user)
);

CREATE TABLE Users(
id_user SERIAL PRIMARY KEY,
nome VARCHAR(150) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
passuord_hash VARCHAR(100) NOT NULL,
created_at TIMESTAMP DEFAULT NOW(),
updated_at TIMESTAMP DEFAULT NOW()
);


CREATE TABLE tasks (
    id_tasks serial PRIMARY KEY,
    title varchar(100) NOT NULL,
    description text,
    status varchar(20) DEFAULT 'pendent',
    priority varchar(10) NOT NULL DEFAULT 'baixo',
    date_begin date,
    date_end date
);
