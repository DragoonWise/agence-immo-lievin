use agenceimmolievin;
Start TRANSACTION;
INSERT INTO `propertytypes` (
    `Id`,
    `Label`,
    `Created_at`,
    `Updated_at`,
    `Deleted_at`,
    `Deleted`
  )
VALUES
  (
    1,
    'Maison',
    '2020-02-20 12:41:12',
    '2020-02-20 12:41:12',
    NULL,
    NULL
  ),
  (
    2,
    'Appartement',
    '2020-02-20 12:41:12',
    '2020-02-20 12:41:12',
    NULL,
    NULL
  );
INSERT INTO `addresses` (
    `Id`,
    `Address1`,
    `Address2`,
    `Address3`,
    `Address4`,
    `PostCode`,
    `City`,
    `State`,
    `Country`,
    `Created_at`,
    `Updated_at`,
    `Deleted_at`,
    `Deleted`
  )
VALUES
  (
    1,
    '',
    '',
    '36 avenue michel bizot',
    '',
    '75012',
    'Paris',
    NULL,
    'France',
    '2020-02-20 12:40:13',
    '2020-02-20 12:40:13',
    NULL,
    NULL
  ),
  (
    2,
    '',
    '',
    '36 avenue michel bizot',
    '',
    '75012',
    'Paris',
    NULL,
    'France',
    '2020-02-20 12:40:22',
    '2020-02-20 12:40:22',
    NULL,
    NULL
  );
INSERT INTO `users` (
    `Id`,
    `IdAddress`,
    `Email`,
    `Password`,
    `LastName`,
    `FirstName`,
    `IsAdmin`,
    `Created_at`,
    `Updated_at`,
    `Deleted_at`,
    `Deleted`
  )
VALUES
  (
    NULL,
    '1',
    'dragoonwise@outlook.fr',
    '$2y$10$.DXhlAOlPtH4GM37/gOMo.VH3KvbAVbbOLu68vwTScypJ4l3c7gtC',
    'Dragoon',
    'Wise',
    '1',
    current_timestamp(),
    current_timestamp(),
    NULL,
    '0'
  );
INSERT INTO `properties` (
    `Id`,
    `IdAddress`,
    `IdPropertyType`,
    `IdUser`,
    `Label`,
    `Description`,
    `IsRental`,
    `Price`,
    `EnergyClass`,
    `LivingSpace`,
    `Rooms`,
    `BedRooms`,
    `IsVisible`,
    `IsTop`,
    `Ref`,
    `Created_at`,
    `Updated_at`,
    `Deleted_at`,
    `Deleted`
  )
VALUES
  (
    NULL,
    '1',
    '2',
    '1',
    'Appartement 22m²',
    '',
    '1',
    '650',
    'C',
    '22',
    '2',
    '1',
    '0',
    '0',
    NULL,
    current_timestamp(),
    current_timestamp(),
    NULL,
    '0'
  );
Commit;