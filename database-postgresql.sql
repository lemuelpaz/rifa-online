-- ============================================================
-- Schema PostgreSQL convertido do MySQL
-- ============================================================

BEGIN;

-- cart_list
CREATE TABLE IF NOT EXISTS cart_list (
  id SERIAL PRIMARY KEY,
  customer_id INTEGER NOT NULL,
  product_id INTEGER NOT NULL,
  quantity INTEGER NOT NULL DEFAULT 0
);

-- config
CREATE TABLE IF NOT EXISTS config (
  id SERIAL PRIMARY KEY,
  user_id INTEGER DEFAULT NULL,
  config VARCHAR(2000) DEFAULT NULL
);

-- customer_list
CREATE TABLE IF NOT EXISTS customer_list (
  id SERIAL PRIMARY KEY,
  firstname TEXT NOT NULL,
  lastname TEXT NOT NULL,
  phone TEXT NOT NULL,
  email VARCHAR(255) DEFAULT NULL,
  password VARCHAR(255) DEFAULT NULL,
  avatar VARCHAR(255) DEFAULT NULL,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  cpf VARCHAR(255) DEFAULT NULL,
  zipcode VARCHAR(255) DEFAULT NULL,
  address VARCHAR(255) DEFAULT NULL,
  number VARCHAR(255) DEFAULT NULL,
  neighborhood VARCHAR(255) DEFAULT NULL,
  complement VARCHAR(255) DEFAULT NULL,
  state VARCHAR(255) DEFAULT NULL,
  city VARCHAR(255) DEFAULT NULL,
  reference_point VARCHAR(255) DEFAULT NULL,
  is_affiliate SMALLINT NOT NULL DEFAULT 0,
  birth DATE DEFAULT NULL,
  instagram TEXT DEFAULT NULL
);

-- logs
CREATE TABLE IF NOT EXISTS logs (
  id SERIAL PRIMARY KEY,
  origin TEXT DEFAULT NULL,
  description TEXT DEFAULT NULL,
  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- migrations
CREATE TABLE IF NOT EXISTS migrations (
  id SERIAL PRIMARY KEY,
  migration VARCHAR(255) NOT NULL,
  batch INTEGER NOT NULL
);

-- order_items
CREATE TABLE IF NOT EXISTS order_items (
  order_id INTEGER NOT NULL,
  product_id INTEGER NOT NULL,
  quantity INTEGER NOT NULL DEFAULT 0,
  price NUMERIC(12,2) NOT NULL
);

-- order_list
CREATE TABLE IF NOT EXISTS order_list (
  id SERIAL PRIMARY KEY,
  code VARCHAR(100) DEFAULT NULL,
  customer_id INTEGER DEFAULT NULL,
  quantity TEXT DEFAULT NULL,
  total_amount NUMERIC(12,2) NOT NULL DEFAULT 0.00,
  status SMALLINT NOT NULL DEFAULT 0,
  roleta INTEGER DEFAULT 0,
  box INTEGER DEFAULT 0,
  roleta_aberta INTEGER DEFAULT 0,
  box_aberta INTEGER DEFAULT 0,
  date_created TIMESTAMP DEFAULT NULL,
  date_updated TIMESTAMP DEFAULT NULL,
  product_name TEXT DEFAULT NULL,
  order_token VARCHAR(100) DEFAULT NULL,
  order_numbers TEXT DEFAULT NULL,
  product_id INTEGER DEFAULT NULL,
  payment_method TEXT DEFAULT NULL,
  order_expiration TEXT DEFAULT NULL,
  pix_code TEXT DEFAULT NULL,
  pix_qrcode TEXT DEFAULT NULL,
  txid TEXT DEFAULT NULL,
  discount_amount TEXT DEFAULT NULL,
  whatsapp_status TEXT DEFAULT NULL,
  dwapi_status TEXT DEFAULT NULL,
  id_mp VARCHAR(100) DEFAULT NULL,
  referral_id INTEGER DEFAULT NULL,
  pixel_sell SMALLINT DEFAULT NULL
);

-- page_view
CREATE TABLE IF NOT EXISTS page_view (
  id SERIAL PRIMARY KEY,
  product_id VARCHAR(11) DEFAULT NULL,
  customer_id VARCHAR(11) DEFAULT NULL,
  page VARCHAR(255) NOT NULL,
  origin SMALLINT NOT NULL DEFAULT 0
);

-- product_list
CREATE TABLE IF NOT EXISTS product_list (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  price NUMERIC(12,2) NOT NULL DEFAULT 0.00,
  image_path VARCHAR(255) DEFAULT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  delete_flag SMALLINT NOT NULL DEFAULT 0,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  type_of_draw SMALLINT NOT NULL DEFAULT 1,
  qty_numbers TEXT NOT NULL DEFAULT '',
  min_purchase TEXT NOT NULL DEFAULT '',
  max_purchase TEXT NOT NULL DEFAULT '',
  slug TEXT NOT NULL DEFAULT '',
  pending_numbers TEXT NOT NULL DEFAULT '',
  paid_numbers TEXT NOT NULL DEFAULT '',
  ranking_qty TEXT NOT NULL DEFAULT '',
  enable_ranking VARCHAR(255) NOT NULL DEFAULT '0',
  image_gallery VARCHAR(255) DEFAULT NULL,
  enable_progress_bar VARCHAR(255) NOT NULL DEFAULT '0',
  draw_number VARCHAR(255) DEFAULT NULL,
  status_display VARCHAR(255) NOT NULL DEFAULT '1',
  subtitle VARCHAR(255) DEFAULT NULL,
  subtitle2 VARCHAR(255) DEFAULT NULL,
  date_of_draw VARCHAR(255) DEFAULT NULL,
  limit_order_remove VARCHAR(255) DEFAULT NULL,
  discount_qty VARCHAR(255) DEFAULT NULL,
  discount_amount VARCHAR(255) DEFAULT NULL,
  enable_discount VARCHAR(255) DEFAULT NULL,
  enable_cumulative_discount VARCHAR(255) DEFAULT NULL,
  enable_sale VARCHAR(255) DEFAULT NULL,
  sale_qty VARCHAR(255) DEFAULT NULL,
  sale_price NUMERIC(12,2) DEFAULT 0.00,
  ranking_message VARCHAR(255) DEFAULT NULL,
  enable_ranking_show VARCHAR(255) DEFAULT NULL,
  draw_winner VARCHAR(255) DEFAULT NULL,
  private_draw VARCHAR(255) NOT NULL DEFAULT '0',
  featured_draw VARCHAR(255) DEFAULT '0',
  enable_cotapremiada VARCHAR(255) NOT NULL DEFAULT '0',
  cotapremiada TEXT DEFAULT NULL,
  cotapremiada_descricao VARCHAR(255) DEFAULT NULL,
  limit_orders INTEGER DEFAULT 0,
  maior_menor VARCHAR(255) DEFAULT '0',
  block_titulo SMALLINT NOT NULL DEFAULT 0,
  titulo_bloqueado TEXT DEFAULT NULL,
  titulo_porcentagem VARCHAR(200) NOT NULL DEFAULT '0.0',
  porcentagem_exibido VARCHAR(200) DEFAULT NULL,
  habilitar_cota_sorte SMALLINT DEFAULT NULL,
  cota_sorte_ini VARCHAR(255) DEFAULT NULL,
  cota_sorte_fim VARCHAR(255) DEFAULT NULL,
  cota_sorte VARCHAR(255) DEFAULT NULL,
  quantidade_compra_sorte VARCHAR(255) DEFAULT NULL,
  status_auto_cota SMALLINT NOT NULL DEFAULT 0,
  valor_base_auto INTEGER NOT NULL DEFAULT 50,
  quantidade_numeros INTEGER NOT NULL DEFAULT 2,
  tipo_auto_cota VARCHAR(255) DEFAULT NULL,
  up SMALLINT NOT NULL DEFAULT 0,
  quantidade_auto_cota INTEGER NOT NULL DEFAULT 50,
  quantidade_auto_cota_diario INTEGER NOT NULL DEFAULT 0,
  cotas_premiadas_premios TEXT NOT NULL DEFAULT '',
  cotas_premiadas_magica VARCHAR(255) DEFAULT NULL,
  roleta SMALLINT DEFAULT NULL,
  box SMALLINT DEFAULT NULL,
  discount_roleta TEXT DEFAULT NULL,
  cota_diaria_ini VARCHAR(255) DEFAULT NULL,
  cota_diaria_fim VARCHAR(255) DEFAULT NULL,
  enable_ranking_definido SMALLINT DEFAULT NULL,
  ranking_ini VARCHAR(255) DEFAULT NULL,
  ranking_fim VARCHAR(255) DEFAULT NULL,
  enable_double SMALLINT DEFAULT NULL,
  double_ini VARCHAR(255) DEFAULT NULL,
  double_fim VARCHAR(255) DEFAULT NULL,
  enable_upsell SMALLINT DEFAULT NULL,
  qtd_upsell VARCHAR(255) DEFAULT NULL,
  desconto_upsell VARCHAR(255) DEFAULT NULL,
  status_auto_cota_roleta SMALLINT DEFAULT NULL,
  tipo_auto_cota_roleta TEXT DEFAULT NULL,
  cotas_premiadas_roleta TEXT DEFAULT NULL,
  cotas_premiadas_premios_roleta TEXT DEFAULT NULL,
  cotas_premiadas_descricao_roleta TEXT DEFAULT NULL,
  box_qty TEXT DEFAULT NULL,
  box_amount TEXT DEFAULT NULL,
  status_auto_cota_box SMALLINT DEFAULT NULL,
  tipo_auto_cota_box TEXT DEFAULT NULL,
  cotas_premiadas_box TEXT DEFAULT NULL,
  cotas_premiadas_premios_box TEXT DEFAULT NULL,
  cotas_premiadas_descricao_box TEXT DEFAULT NULL,
  roleta_qty TEXT DEFAULT NULL,
  roleta_amount TEXT DEFAULT NULL,
  probabilidade VARCHAR(255) DEFAULT NULL,
  qtd_limite VARCHAR(255) DEFAULT NULL,
  cotas_premiadas TEXT DEFAULT NULL,
  cotas_premiadas_descricao TEXT DEFAULT NULL,
  ranking_type INTEGER DEFAULT NULL,
  qty_select_1 INTEGER NOT NULL DEFAULT 10,
  qty_select_2 INTEGER NOT NULL DEFAULT 20,
  qty_select_3 INTEGER NOT NULL DEFAULT 50,
  qty_select_4 INTEGER NOT NULL DEFAULT 100,
  qty_select_5 INTEGER NOT NULL DEFAULT 200,
  qty_select_6 INTEGER NOT NULL DEFAULT 300,
  enable_progress_bar_fake SMALLINT DEFAULT NULL,
  enable_progress_bar_fake_value VARCHAR(11) DEFAULT NULL,
  habilitar_cota_sorte_roleta SMALLINT DEFAULT NULL,
  cota_sorte_ini_roleta VARCHAR(255) DEFAULT NULL,
  cota_sorte_fim_roleta VARCHAR(255) DEFAULT NULL,
  cota_sorte_roleta VARCHAR(11) DEFAULT NULL,
  quantidade_compra_sorte_roleta VARCHAR(11) DEFAULT NULL,
  habilitar_cota_sorte_box SMALLINT DEFAULT NULL,
  cota_sorte_ini_box VARCHAR(255) DEFAULT NULL,
  cota_sorte_fim_box VARCHAR(255) DEFAULT NULL,
  cota_sorte_box VARCHAR(11) DEFAULT NULL,
  quantidade_compra_sorte_box VARCHAR(11) DEFAULT NULL
);

-- referral
CREATE TABLE IF NOT EXISTS referral (
  id SERIAL PRIMARY KEY,
  status SMALLINT DEFAULT 0,
  referral_code VARCHAR(100) DEFAULT NULL,
  percentage NUMERIC(12,2) NOT NULL DEFAULT 0.00,
  amount_paid NUMERIC(12,2) NOT NULL DEFAULT 0.00,
  amount_pending NUMERIC(12,2) NOT NULL DEFAULT 0.00,
  customer_id INTEGER NOT NULL
);

-- referral_transactions
CREATE TABLE IF NOT EXISTS referral_transactions (
  id SERIAL PRIMARY KEY,
  total_amount NUMERIC(12,2) NOT NULL DEFAULT 0.00,
  referral_id INTEGER NOT NULL
);

-- system_info
CREATE TABLE IF NOT EXISTS system_info (
  id SERIAL PRIMARY KEY,
  meta_field TEXT NOT NULL,
  meta_value TEXT NOT NULL
);

-- users
CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  firstname VARCHAR(250) NOT NULL,
  middlename TEXT DEFAULT NULL,
  lastname VARCHAR(250) NOT NULL,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  avatar TEXT DEFAULT NULL,
  last_login TIMESTAMP DEFAULT NULL,
  type SMALLINT NOT NULL DEFAULT 0,
  date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email TEXT DEFAULT NULL,
  site VARCHAR(200) DEFAULT NULL
);

-- ============================================================
-- Índices
-- ============================================================
CREATE INDEX IF NOT EXISTS idx_cart_customer   ON cart_list(customer_id);
CREATE INDEX IF NOT EXISTS idx_cart_product    ON cart_list(product_id);
CREATE INDEX IF NOT EXISTS idx_order_customer  ON order_list(customer_id);
CREATE INDEX IF NOT EXISTS idx_order_product   ON order_list(product_id, code);
CREATE INDEX IF NOT EXISTS idx_referral_cust   ON referral(customer_id);
CREATE INDEX IF NOT EXISTS idx_oi_order        ON order_items(order_id);
CREATE INDEX IF NOT EXISTS idx_oi_product      ON order_items(product_id);

-- ============================================================
-- Chaves estrangeiras
-- ============================================================
DO $$ BEGIN
  ALTER TABLE cart_list ADD CONSTRAINT customer_id_fk_cl FOREIGN KEY (customer_id) REFERENCES customer_list(id) ON DELETE CASCADE;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

DO $$ BEGIN
  ALTER TABLE cart_list ADD CONSTRAINT product_id_fk_cl FOREIGN KEY (product_id) REFERENCES product_list(id) ON DELETE CASCADE;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

DO $$ BEGIN
  ALTER TABLE order_items ADD CONSTRAINT order_id_fk_oi FOREIGN KEY (order_id) REFERENCES order_list(id) ON DELETE CASCADE;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

DO $$ BEGIN
  ALTER TABLE order_items ADD CONSTRAINT product_id_fk_oi FOREIGN KEY (product_id) REFERENCES product_list(id) ON DELETE CASCADE;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

DO $$ BEGIN
  ALTER TABLE order_list ADD CONSTRAINT customer_id_fk_ol FOREIGN KEY (customer_id) REFERENCES customer_list(id) ON DELETE CASCADE;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

DO $$ BEGIN
  ALTER TABLE referral ADD CONSTRAINT customer_id_fk_re FOREIGN KEY (customer_id) REFERENCES customer_list(id) ON DELETE CASCADE;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

-- ============================================================
-- Dados obrigatórios
-- ============================================================

INSERT INTO migrations (id, migration, batch) VALUES
(1,  '2024_05_14_045711_create_cart_list_table', 0),
(2,  '2024_05_14_045711_create_config_table', 0),
(3,  '2024_05_14_045711_create_customer_list_table', 0),
(4,  '2024_05_14_045711_create_logs_table', 0),
(5,  '2024_05_14_045711_create_order_items_table', 0),
(6,  '2024_05_14_045711_create_order_list_table', 0),
(7,  '2024_05_14_045711_create_product_list_table', 0),
(8,  '2024_05_14_045711_create_referral_table', 0),
(9,  '2024_05_14_045711_create_referral_transactions_table', 0),
(10, '2024_05_14_045711_create_system_info_table', 0),
(11, '2024_05_14_045711_create_users_table', 0),
(12, '2024_05_14_045714_add_foreign_keys_to_cart_list_table', 0),
(13, '2024_05_14_045714_add_foreign_keys_to_order_items_table', 0),
(14, '2024_05_14_045714_add_foreign_keys_to_order_list_table', 0),
(15, '2024_05_14_045714_add_foreign_keys_to_referral_table', 0)
ON CONFLICT (id) DO NOTHING;

INSERT INTO system_info (id, meta_field, meta_value) VALUES
(1,   'name',                    'Obetzera Rifa'),
(2,   'short_name',              ''),
(3,   'logo',                    'uploads/logo.png?v=1758355735'),
(4,   'user_avatar',             'uploads/user_avatar.jpg'),
(5,   'cover',                   'uploads/cover.png?v=1675042834'),
(6,   'phone',                   '1140028922'),
(7,   'mobile',                  '00000'),
(8,   'email',                   '@gmail.com '),
(9,   'address',                 'Endereço'),
(10,  'mercadopago',             '2'),
(11,  'mercadopago_access_token','1122'),
(12,  'gerencianet',             '2'),
(13,  'gerencianet_client_id',   ''),
(14,  'gerencianet_client_secret',''),
(15,  'gerencianet_pix_key',     ''),
(16,  'gateway',                 '1'),
(17,  'enable_cpf',              '1'),
(18,  'enable_email',            '2'),
(19,  'enable_address',          '2'),
(20,  'favicon',                 'uploads/favicon.png?v=1758355735'),
(21,  'enable_share',            '1'),
(22,  'enable_groups',           '1'),
(23,  'telegram_group_url',      'https://obetzera.com/'),
(24,  'whatsapp_group_url',      'https://obetzera.com/'),
(25,  'enable_footer',           '1'),
(26,  'text_footer',             ''),
(27,  'enable_password',         '2'),
(28,  'paggue',                  '2'),
(29,  'paggue_client_key',       ''),
(30,  'paggue_client_secret',    ''),
(31,  'enable_pixel',            '2'),
(32,  'facebook_access_token',   ''),
(33,  'facebook_pixel_id',       ''),
(34,  'enable_hide_numbers',     '1'),
(35,  'whatsapp_footer',         'https://obetzera.com/'),
(36,  'instagram_footer',        'https://obetzera.com/'),
(37,  'facebook_footer',         'https://obetzera.com/'),
(38,  'twitter_footer',          'https://obetzera.com/'),
(39,  'youtube_footer',          'https://obetzera.com/'),
(40,  'enable_dwapi',            '2'),
(41,  'token_dwapi',             ''),
(42,  'numero_dwapi',            ''),
(43,  'mensagem_novo_pedido_dwapi',''),
(44,  'mensagem_pedido_pago_dwapi',''),
(45,  'smtp_host',               ''),
(46,  'smtp_port',               '465'),
(47,  'smtp_user',               ''),
(48,  'smtp_pass',               ''),
(49,  'question1',               'Como acessar minhas compras?'),
(50,  'answer1',                 'Fazendo login no site e abrindo o Menu Principal, você consegue consultar suas últimas compras no menu'),
(51,  'question2',               'Como envio o comprovante?'),
(52,  'answer2',                 'Caso você tenha feito o pagamento via Pix QR Code ou copiando o código, não é necessário enviar o comprovante.'),
(53,  'question3',               'Como é o processo do sorteio?'),
(54,  'answer3',                 'O sorteio será realizado com base na extração da Loteria Federal.'),
(55,  'question4',               ''),
(56,  'answer4',                 ''),
(57,  'terms',                   'Termos de uso do sistema.'),
(58,  'enable_ga4',              '2'),
(59,  'google_ga4_id',           ''),
(60,  'license',                 ''),
(61,  'enable_two_phone',        '2'),
(62,  'enable_gtm',              '2'),
(63,  'google_gtm_id',           ''),
(64,  'theme',                   '2'),
(65,  'email_order',             ''),
(66,  'email_purchase',          ''),
(67,  'enable_legal_age',        '2'),
(68,  'enable_birth',            '2'),
(69,  'enable_instagram',        '2'),
(70,  'enable_multiple_order',   '2'),
(71,  'dealer_active',           '2'),
(72,  'dealer_deactive_site',    '2'),
(73,  'dealer_split_mercadopago','2'),
(74,  'mercadopago_tax',         ''),
(75,  'gerencianet_tax',         ''),
(76,  'paggue_tax',              '0'),
(77,  'openpix_app_id',          ''),
(78,  'openpix_tax',             ''),
(79,  'pay2m_client_id',         ''),
(80,  'pay2m_client_secret',     ''),
(81,  'pay2m_tax',               '0'),
(82,  'openpix',                 '2'),
(83,  'pay2m',                   '2'),
(85,  'pagstar',                 '2'),
(86,  'pagstar_client_key',      ''),
(87,  'pagstar_client_secret',   ''),
(88,  'openpix_webhook_url',     ''),
(89,  'pagstar2',                '2'),
(90,  'Pagstar_webhook_url',     ''),
(91,  'ondapay',                 '2'),
(92,  'ondapay_client_id',       ''),
(93,  'ondapay_client_secret',   ''),
(94,  'nextpay',                 '2'),
(95,  'nextpay_client_id',       ''),
(96,  'nextpay_client_secret',   ''),
(97,  'nextpay_webhook',         ''),
(98,  'ativopay',                '2'),
(99,  'ativopay_client_id',      ''),
(100, 'ativopay_client_secret',  ''),
(101, 'ativopay_webhook',        ''),
(102, 'pay2m_webhook_url',       ''),
(103, 'paggue_webhook_url',      ''),
(104, 'ondapay_webhook_url',     ''),
(105, 'ativopay_webhook_url',    ''),
(106, 'bestfy',                  '2'),
(107, 'bestfy_client_id',        ''),
(108, 'bestfy_client_secret',    ''),
(109, 'bestfy_webhook',          ''),
(110, 'phpay',                   '2'),
(111, 'phpay_client_id',         ''),
(112, 'phpay_client_secret',     ''),
(113, 'phpay_webhook',           ''),
(114, 'kapay_client_id',         ''),
(115, 'kapay_client_secret',     ''),
(116, 'kapay_webhook',           ''),
(117, 'kapay',                   '2'),
(118, 'connectpay',              '2'),
(119, 'connectpay_client_id',    ''),
(120, 'connectpay_client_secret',''),
(121, 'connectpay_webhook',      ''),
(122, 'connectpay_webhook_url',  ''),
(123, 'ondapay_pix_key',         ''),
(124, 'ezzepay',                 '2'),
(125, 'pixup',                   '2'),
(126, 'pixup_client_id',         ''),
(127, 'pixup_client_secret',     '')
ON CONFLICT (id) DO NOTHING;

INSERT INTO users (id, firstname, middlename, lastname, username, password, avatar, last_login, type, date_added, date_updated, email, site) VALUES
(1, 'OBET', '', 'ZERA', 'Obetzera01', '05b4fb6313455f29a6c191b3521f04ab', 'uploads/avatars/1.png', NULL, 1, '2021-01-20 14:02:37', '2025-09-20 08:09:04', 'obetzera@gmail.com', NULL)
ON CONFLICT (id) DO NOTHING;

INSERT INTO product_list (id, name, description, price, image_path, status, delete_flag, date_created, date_updated, type_of_draw, qty_numbers, min_purchase, max_purchase, slug, pending_numbers, paid_numbers, ranking_qty, enable_ranking, image_gallery, enable_progress_bar, draw_number, status_display, subtitle, subtitle2, date_of_draw, limit_order_remove, discount_qty, discount_amount, enable_discount, enable_cumulative_discount, enable_sale, sale_qty, sale_price, ranking_message, enable_ranking_show, draw_winner, private_draw, featured_draw, enable_cotapremiada, cotapremiada, cotapremiada_descricao, limit_orders, maior_menor, block_titulo, titulo_bloqueado, titulo_porcentagem, porcentagem_exibido, habilitar_cota_sorte, cota_sorte_ini, cota_sorte_fim, cota_sorte, quantidade_compra_sorte, status_auto_cota, valor_base_auto, quantidade_numeros, tipo_auto_cota, up, quantidade_auto_cota, quantidade_auto_cota_diario, cotas_premiadas_premios, cotas_premiadas_magica, roleta, box, discount_roleta, cota_diaria_ini, cota_diaria_fim, enable_ranking_definido, ranking_ini, ranking_fim, enable_double, double_ini, double_fim, enable_upsell, qtd_upsell, desconto_upsell, status_auto_cota_roleta, tipo_auto_cota_roleta, cotas_premiadas_roleta, cotas_premiadas_premios_roleta, cotas_premiadas_descricao_roleta, box_qty, box_amount, status_auto_cota_box, tipo_auto_cota_box, cotas_premiadas_box, cotas_premiadas_premios_box, cotas_premiadas_descricao_box, roleta_qty, roleta_amount, probabilidade, qtd_limite, cotas_premiadas, cotas_premiadas_descricao, ranking_type, qty_select_1, qty_select_2, qty_select_3, qty_select_4, qty_select_5, qty_select_6, enable_progress_bar_fake, enable_progress_bar_fake_value, habilitar_cota_sorte_roleta, cota_sorte_ini_roleta, cota_sorte_fim_roleta, cota_sorte_roleta, quantidade_compra_sorte_roleta, habilitar_cota_sorte_box, cota_sorte_ini_box, cota_sorte_fim_box, cota_sorte_box, quantidade_compra_sorte_box) VALUES
(128, 'POP 110I ZERO KM POP 110I ZERO KM', 'POP 110I ZERO KM&#13;&#10;POP 110I ZERO KM', 0.90, 'uploads/campanhas/image (23).png', 1, 0, '2025-05-13 22:59:01', '2025-09-19 07:52:36', 1, '10000000', '3', '5000', 'pop-110i-zero-km-pop-110i-zero-km-2', '1105', '31', '0', '0', '[\"uploads\\/campanhas\\/1image (23).png\"]', '0', '', '2', 'POP 110I ZERO KM POP 110I ZERO KM', NULL, '', '5', '[\"2000\",\"4000\",\"5000\"]', '[\"5.00\",\"5.00\",\"5.00\"]', '1', '0', '0', '0', 0.00, 'Quem comprar mais Bilhete, o 1º lugar ganha: R$', '0', '[""]', '0', '1', '0', NULL, NULL, 0, '0', 0, NULL, '0.0', NULL, 0, '', '', '', '', 0, 0, 2, '111111,22222,33333,55555,66666,77777,88888,99999', 0, 0, 0, '111111:$500:premiada,22222:$500:premiada,33333:$500:premiada,55555:$500:premiada,66666:$500:premiada,77777:$500:premiada,88888:$500:premiada,99999:$500:premiada', NULL, 1, 1, NULL, '2025-05-31T08:00', '2025-05-31T23:00', 0, '', '', 1, '2025-05-13T08:00', '2025-05-15T20:00', 0, '', '', 0, '101010,101011,101012,101013,101014,101015,101016,101017,101018,101019', '101010,101011,101012,101013,101014,101015,101016,101017,101018,101019', '101010:$500:premiada,101011:$500:premiada,101012:$500:premiada,101013:$500:premiada,101014:$500:premiada,101015:$500:premiada,101016:$500:premiada,101017:$500:premiada,101018:$500:premiada,101019:$500:premiada', '', '[\"1\"]', '[\"100\"]', 1, '202020,202021,202023,202024,202025,202026,202027,202028,202029', '202020,202021,202023,202024,202025,202026,202027,202028,202029', '202020:$500:premiada,202021:$500:premiada,202023:$500:premiada,202024:$500:premiada,202025:$500:premiada,202026:$500:premiada,202027:$500:premiada,202028:$500:premiada,202029:$500:premiada', '', '[\"1\"]', '[\"350\"]', '50', NULL, '111111,22222,33333,55555,66666,77777,88888,99999', '', 1, 100, 200, 500, 1000, 2000, 5000, 1, '38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
ON CONFLICT (id) DO NOTHING;

-- ============================================================
-- Resetar sequences para os IDs inseridos manualmente
-- ============================================================
SELECT setval('migrations_id_seq',    (SELECT MAX(id) FROM migrations));
SELECT setval('system_info_id_seq',   (SELECT MAX(id) FROM system_info));
SELECT setval('users_id_seq',         (SELECT MAX(id) FROM users));
SELECT setval('product_list_id_seq',  (SELECT MAX(id) FROM product_list));

COMMIT;
