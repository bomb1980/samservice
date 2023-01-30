INSERT INTO DPISEMP1.PER_SQL (SQL_CODE,SQL_NAME,SQL_CMD,UPDATE_USER,UPDATE_DATE) VALUES
	 ('002','เกี่ยวกับอัพโหลดรูปไม่ได้','ALTER TABLE DPISEMP1.PER_PERSONALPIC ADD PIC_SERVER_ID number(10,0);
ALTER TABLE DPISEMP1.PER_PERSONALPIC ADD PIC_SIGN number(5,0);
',1,'2017-05-25 08:40:51'),
	 ('001','ปรับเงินค่าเงินเดือน ก่อน ปรับ','UPDATE ( select * from per_personal where per_id in (select per_id from
per_comdtl where com_id=607)) a
SET a.per_salary = ( SELECT distinct b.cmd_old_salary  FROM per_comdtl
b WHERE b.com_id=607 and  a.per_id= b.per_id  )',1,'2011-07-06 14:38:22');
