/*DROP DATABASE sns2;*/
CREATE DATABASE  sns2;
USE sns2;

CREATE TABLE college_list(/*カレッジ一覧*/
	id INT(4) PRIMARY KEY,/*カレッジID*/
	name VARCHAR(16) NOT NULL);/*名前*/

CREATE TABLE group_detail(/*グループ詳細*/
	id VARCHAR(8) PRIMARY KEY,/*グループID*/
	name VARCHAR(32) NOT NULL,/*グループ名*/
	overview TEXT NOT NULL);/*概要*/

CREATE TABLE group_list(/*グループ一覧*/
	group_id VARCHAR(32) PRIMARY KEY,/*グループID*/
	college_id INT(4),/*カレッジID*/
	FOREIGN KEY(group_id) REFERENCES group_detail(id),
	FOREIGN KEY(college_id) REFERENCES college_list(id));

CREATE TABLE user_detail(/*ユーザ詳細*/
	id VARCHAR(32) PRIMARY KEY,/*ログインID*/
	name VARCHAR(32) NOT NULL,/*名前*/
	sex ENUM('男','女'),/*性別*/
	mail VARCHAR(64) UNIQUE NOT NULL ,/*メールアドレス*/
	college_id INT,/*カレッジID*/
	group_id VARCHAR(8),/*グループID*/
	prof TEXT,/*プロフィール*/
	picture BLOB,/*プロフィール画像*/
	FOREIGN KEY(college_id) REFERENCES college_list(id),
	FOREIGN KEY(group_id) REFERENCES group_list(group_id));

CREATE TABLE post_contents(/*投稿内容*/
	id INT(32)PRIMARY KEY,/*投稿ID*/
	contents TEXT,/*投稿内容*/
	picture BLOB,/*投稿画像*/
	posttime DATETIME,/*登校時間*/
	login_id VARCHAR(32),/*ログインID*/
	FOREIGN KEY(login_id) REFERENCES user_detail(id));

CREATE TABLE info(/*お知らせ*/
	id INT(32) PRIMARY KEY,/*記事ID*/
	login_id VARCHAR(32),/*ログインID*/
	posttime DATETIME,/*投稿日時*/
	article TEXT,/*記事内容*/
	FOREIGN KEY(login_id) REFERENCES user_detail(id));

CREATE TABLE comment(/*コメント内容*/
	id VARCHAR(16) PRIMARY KEY,/*コメントID*/
	contents TEXT NOT NULL,/*コメント内容*/
	login_id VARCHAR(32),/*ログインID*/
	FOREIGN KEY(login_id) REFERENCES user_detail(id));

CREATE TABLE post_list(/*投稿一覧*/
	group_id VARCHAR(8) PRIMARY KEY,/*グループID*/
	post_id INT(32),/*投稿ID*/
	FOREIGN KEY(group_id) REFERENCES group_detail(id),
	FOREIGN KEY(post_id) REFERENCES post_contents(id));

CREATE TABLE user_login(/*ユーザ*/
	id VARCHAR(32) PRIMARY KEY,/*ログインID*/
	pass VARCHAR(32) NOT NULL,/*パスワード*/
	grand ENUM('0','1'),/*マスターフラグ(0=学生)*/
	FOREIGN KEY(id) REFERENCES user_detail(id));

CREATE TABLE reply_contents(/*リプライ内容*/
	id INT(32) PRIMARY KEY,/*リプライID*/
	contents TEXT NOT NULL);/*リプライ内容*/

CREATE TABLE reply_list(/*リプライ一覧*/
	contents_id INT(32) PRIMARY KEY,/*投稿ID*/
	reply_id INT(32),/*リプライID*/
	FOREIGN KEY(contents_id) REFERENCES post_contents(id),
	FOREIGN KEY(reply_id) REFERENCES reply_contents(id));

CREATE TABLE chat_history(/*グループチャットID*/
	group_id VARCHAR(8) PRIMARY KEY,/*グループID*/
	comment_id VARCHAR(16),/*コメントID*/
	FOREIGN KEY(group_id) REFERENCES group_list(group_id),
	FOREIGN KEY(comment_id) REFERENCES comment(id));
