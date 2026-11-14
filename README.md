# MediLog website

Static website for [MediLog](https://www.medilog.co.uk), the care management app. Rebuilt from the previous Wix site for hosting on Hostinger.

## Structure

| Path | Purpose |
| --- | --- |
| `index.html` | Home |
| `faq.html`, `blog.html`, `contact.html` | FAQ, blog list, contact form |
| `post/makinghealthcareseamless.html` | Blog post |
| `privacypolicy.html`, `cookiepolicy.html`, `usermanual.html` | Policy and manual pages |
| `thanks.html`, `404.html` | Form confirmation and not-found pages |
| `send.php` | Contact form handler (PHP `mail()`) |
| `.htaccess` | Serves `/faq`, `/blog`, `/post/...` etc. without `.html`, so the old Wix addresses keep working |
| `assets/` | CSS, JavaScript, fonts (Poppins) and images |
| `robots.txt`, `sitemap.xml` | Search engine files |

## Deploying to Hostinger

Upload the contents of this repository into `public_html` (File Manager, or hPanel's Git deployment pointed at this repository). `index.html` must sit directly inside `public_html`.

## Contact form

`send.php` sends messages with PHP `mail()`. The recipient and sender addresses are the two constants at the top of the file. The sender must be a mailbox on the website's own domain.

The form only works on a PHP host, not when the pages are opened from disk.
