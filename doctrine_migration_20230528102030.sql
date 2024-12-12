-- Doctrine Migration File Generated on 2023-05-28 10:20:30

-- Version DoctrineMigrations\Version20230528093750
ALTER TABLE profile_scope DROP FOREIGN KEY FK_F77BCA01B6C79646;
DROP INDEX IDX_F77BCA01B6C79646 ON profile_scope;
ALTER TABLE profile_scope DROP scopes_id;
