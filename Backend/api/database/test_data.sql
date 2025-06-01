-- Insert data organisasi
INSERT INTO organizations (
    organization_name,
    registration_number,
    office_address,
    official_phone,
    official_email,
    password,
    field_of_work,
    description,
    status
) VALUES (
    'Selaras Jiwa',
    'REG-001',
    'Jl. Contoh No. 123, Jakarta',
    '081234567890',
    'mahardika@selarasjiwa.com',
    '$2y$12$mwl3E1Z/RYGKgWh4rTlrJOXojNgxSJybvUClPRnBCFf1N7VecLNZC', -- password: adminselarrasjiwa
    'Kesehatan Mental',
    'Organisasi yang fokus pada kesehatan mental dan kesejahteraan psikologis',
    'active'
); 
