-- Données de démonstration pour Vite & Gourmand
-- À importer uniquement dans une base de test fraîchement créée.
-- Ne pas importer dans une base contenant déjà ces identifiants.

START TRANSACTION;

INSERT INTO `categories`
    (`id`, `name`, `slug`, `status`, `show_at_home`, `created_at`, `updated_at`)
VALUES
    (1, 'Burger',   'burger',   1, 1, NOW(), NOW()),
    (2, 'Sandwich', 'sandwich', 1, 1, NOW(), NOW()),
    (3, 'Taco',     'taco',     1, 1, NOW(), NOW());

INSERT INTO `menus`
    (`id`, `name`, `created_at`, `updated_at`)
VALUES
    (1, 'main_menu',        '2026-10-03 00:05:06', '2026-10-03 00:05:06'),
    (2, 'footer_menu_one',  '2026-10-03 00:30:26', '2026-10-03 00:30:26'),
    (3, 'footer_menu_two',  '2026-10-03 00:31:11', '2026-10-03 00:31:11'),
    (4, 'footer_menu_three','2026-10-03 00:31:50', '2026-10-03 00:31:50');

INSERT INTO `menu_items`
    (`id`, `label`, `link`, `parent`, `sort`, `class`, `menu`, `depth`,
     `created_at`, `updated_at`, `role_id`)
VALUES
    (1,  'Home',                  '/',                         0,  0, NULL, 2, 0, '2026-10-02 22:42:55', '2026-10-02 22:44:22', 0),
    (2,  'About',                 '/about',                    0,  1, NULL, 2, 0, '2026-10-02 22:44:22', '2026-10-02 22:45:52', 0),
    (3,  'Contact',               '/contact',                  0,  2, NULL, 2, 0, '2026-10-02 22:45:51', '2026-10-02 22:52:09', 0),
    (4,  'Terms and Conditions',  '/terms-and-condistions',     0,  4, NULL, 2, 0, '2026-10-02 22:52:09', '2026-10-03 00:46:54', 0),
    (5,  'Blogs',                 '/blogs',                    0,  3, NULL, 2, 0, '2026-10-02 22:54:01', '2026-10-03 00:46:54', 0),
    (7,  'Payment',               '/payment-methods',           0,  0, NULL, 3, 0, '2026-10-03 00:00:41', '2026-10-03 00:27:26', 0),
    (8,  'Privacy Policy',        '/privacy-policy',            0,  1, NULL, 3, 0, '2026-10-03 00:02:28', '2026-10-03 00:03:16', 0),
    (10, 'Home',                  '/',                         0,  0, NULL, 1, 0, '2026-10-03 07:14:59', '2026-10-03 07:15:25', 0),
    (11, 'About',                 '/about',                    0,  1, NULL, 1, 0, '2026-10-03 07:15:24', '2026-10-03 07:16:07', 0),
    (12, 'Chefs',                 '/chef',                    20,  4, NULL, 1, 1, '2026-10-03 07:16:07', '2026-10-03 08:04:20', 0),
    (13, 'Blogs',                 '/blogs',                    0,  2, NULL, 1, 0, '2026-10-03 07:16:27', '2026-10-03 07:36:24', 0),
    (14, 'Contact',               '/contact',                  0, 10, NULL, 1, 0, '2026-10-03 07:16:55', '2026-10-03 08:02:07', 0),
    (15, 'Testimonials',          '/testimonial',              20,  7, NULL, 1, 1, '2026-10-03 07:17:59', '2026-10-03 08:02:07', 0),
    (16, 'Privacy Policy',        '/privacy-policy',            20,  8, NULL, 1, 1, '2026-10-03 07:19:39', '2026-10-03 08:02:07', 0),
    (17, 'Terms And Conditions',  '/terms-and-condistions',     20,  9, NULL, 1, 1, '2026-10-03 07:21:24', '2026-10-03 08:02:07', 0),
    (18, 'Payment',               '/payment-methods',           20,  6, NULL, 1, 1, '2026-10-03 07:22:29', '2026-10-03 08:02:07', 0),
    (19, 'Blog Details',          '/blogs',                    20,  5, NULL, 1, 1, '2026-10-03 07:25:39', '2026-10-03 08:02:07', 0),
    (20, 'Pages',                 '#',                          0,  3, NULL, 1, 0, '2026-10-03 07:29:26', '2026-10-03 08:02:07', 0),
    (21, 'Menu',                  '/products',                  0,  1, NULL, 1, 0, '2026-10-03 07:29:26', '2026-10-03 08:02:07', 0);

COMMIT;
