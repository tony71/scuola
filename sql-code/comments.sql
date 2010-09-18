-- Tabella Persone
comment on column persone.id_persona is E'Id Persona\nlabel@it="Persona Id:"\nshow="false"\nsize="4"';
comment on column persone.nome is E'size="15"';
comment on column persone.cognome is E'size="15"';
comment on column persone.id_famiglia is E'label@it="Famiglia:"\nsize="5"';
comment on column persone.professione is E'size="16"';
comment on column persone.data_nascita is E'label@it="Data di Nascita:"';

-- Tabella pagamenti.addebiti
COMMENT ON COLUMN pagamenti.addebiti.importo IS 'size="8"';
COMMENT ON COLUMN pagamenti.addebiti.causale IS 'size="20"';
