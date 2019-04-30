ALTER TABLE `Organizations`  DROP `EnrollmentCode`;
ALTER TABLE `Organizations` DROP `Type`;
alter table Organizations add email varchar(255);
