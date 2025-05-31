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
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: adminselarrasjiwa
    'Kesehatan Mental',
    'Organisasi yang fokus pada kesehatan mental dan kesejahteraan psikologis',
    'active'
); 