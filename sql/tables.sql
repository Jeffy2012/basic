CREATE TABLE user (
 user_id Mediumint UNSIGNED AUTO_INCREMENT, /* 用户编号  自增*/
 email VARCHAR(100) UNIQUE NOT NULL, /*用户邮箱 唯一*/
 phone_number varchar(11) UNIQUE,/* 手机号码  唯一*/
 nickname VARCHAR(20) UNIQUE, /*用户昵称 唯一*/
 gender ENUM('M','F','N') DEFAULT 'N', /* 性别 M 男 F 女 N 未知 */
 password CHAR(64), /*密码*/
 activated ENUM('E','P','A','N') DEFAULT 'N', /* 是否激活 E 邮箱激活, P 手机激活， A 都已激活，N 未激活*/
 created_at DATETIME NOT NULL, /* 创建时间 */
 updated_at DATETIME,  /* 更新时间 */
 activated_at DATETIME,/* 激活时间 */
 auth_key CHAR(32) NOT NULL,
 CONSTRAINT pk_user PRIMARY KEY (user_id)
)