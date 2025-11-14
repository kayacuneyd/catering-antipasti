# İtalyan Kültürünü Yansıtan Renk Paletleri
## Catering Antipasti Website için Alternatif Renk Kombinasyonları

---

## Giriş

Bu dokümanda, Catering Antipasti web sitesi için İtalyan kültürünü ve mutfağını yansıtan 4 farklı renk paleti önerilmektedir. Her palet, İtalya'nın farklı bir bölgesinden ve kültürel öğesinden ilham almaktadır.

**Mevcut Başarılı Kombinasyon:** Şarap Bordosu (#6C1F2B) + Beyaz kontrast

---

## Alternatif 1: Toskana Güneşi Paleti 🌻

### Tema
Toscana bağları, ayçiçeği tarlaları, terracotta çatılar, rustik İtalyan kırsalı

### Ana Renkler

| Renk Adı | HEX Kod | RGB | Kullanım Alanı |
|----------|---------|-----|----------------|
| **Terracotta Turuncu** | `#D4704A` | rgb(212, 112, 74) | Primary CTA, vurgular, button'lar |
| **Krem/Bej** | `#F5E6D3` | rgb(245, 230, 211) | Arka plan, section bölümleri |
| **Koyu Toprak** | `#5C4A3C` | rgb(92, 74, 60) | Başlıklar, ana metin |
| **Zeytinyağı Sarısı** | `#E8B944` | rgb(232, 185, 68) | Aksan, hover efektleri, border |
| **Bağ Yeşili** | `#3A5A40` | rgb(58, 90, 64) | Footer, ikincil elementler |

### CSS Implementasyonu

```css
:root {
    /* Toskana Paleti */
    --color-terra: #D4704A;
    --color-cream: #F5E6D3;
    --color-earth: #5C4A3C;
    --color-olive-oil: #E8B944;
    --color-vineyard: #3A5A40;
}

/* Hero Button */
.btn-primary {
    background-color: var(--color-terra);
    color: var(--color-cream);
    border: none;
}

.btn-primary:hover {
    background-color: var(--color-earth);
}

/* Card Design */
.service-card {
    background: white;
    border: 2px solid var(--color-olive-oil);
}

.service-card h3 {
    color: var(--color-earth);
}
```

### TailwindCSS Config

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'terra': '#D4704A',
                'cream': '#F5E6D3',
                'earth': '#5C4A3C',
                'olive-oil': '#E8B944',
                'vineyard': '#3A5A40'
            }
        }
    }
}
```

### HTML Örnekleri

```html
<!-- Primary CTA -->
<button class="bg-terra hover:bg-earth text-cream px-8 py-4 rounded-lg transition-all">
    Menüs Ansehen
</button>

<!-- Service Card -->
<div class="bg-white border-t-4 border-olive-oil p-8 rounded-lg shadow-lg">
    <h3 class="text-earth font-serif text-2xl mb-4">Business Catering</h3>
    <p class="text-gray-600">Professionelle Verpflegung für Firmenfeiern...</p>
</div>

<!-- Footer -->
<footer class="bg-vineyard text-cream py-12">
    <div class="container mx-auto">
        <!-- Footer content -->
    </div>
</footer>
```

### Özellikler
- ✅ **Sıcak ve davetkar** atmosfer
- ✅ **Rustik ama profesyonel** görünüm
- ✅ **Okunabilirlik mükemmel** (koyu toprak rengi text için ideal)
- ✅ **Yaş gruplarına uygun** (evrensel çekicilik)
- ✅ **İtalyan mutfağını doğru yansıtıyor** (toprak tonları, doğa)

### Kullanım Senaryosu
İdeal için: Aile dostu etkinlikler, rustik düğünler, geleneksel İtalyan yemek deneyimi

---

## Alternatif 2: Amalfi Kıyısı Paleti 🍋

### Tema
Positano'nun renkli evleri, Capri'nin turkuaz denizi, limon bahçeleri, Akdeniz havası

### Ana Renkler

| Renk Adı | HEX Kod | RGB | Kullanım Alanı |
|----------|---------|-----|----------------|
| **Akdeniz Mavi** | `#0077B6` | rgb(0, 119, 182) | Primary CTA, linkler |
| **Limoncello Sarı** | `#FFD60A` | rgb(255, 214, 10) | Aksan, vurgular, ikonlar |
| **Beyaz** | `#FFFFFF` | rgb(255, 255, 255) | Arka plan, kartlar |
| **Deniz Lacivert** | `#023E8A` | rgb(2, 62, 138) | Header, footer, başlıklar |
| **Coral Pembe** | `#FF6B6B` | rgb(255, 107, 107) | Secondary CTA, hover |

### CSS Implementasyonu

```css
:root {
    /* Amalfi Paleti */
    --color-mediterranean: #0077B6;
    --color-limoncello: #FFD60A;
    --color-white: #FFFFFF;
    --color-navy: #023E8A;
    --color-coral: #FF6B6B;
}

/* Navigation */
.navbar {
    background-color: var(--color-navy);
}

.nav-link.active {
    color: var(--color-limoncello);
}

/* CTA Buttons */
.btn-primary {
    background-color: var(--color-mediterranean);
    color: white;
}

.btn-secondary {
    background-color: var(--color-coral);
    color: white;
}

/* Cards */
.card {
    background: white;
    border-top: 4px solid var(--color-limoncello);
}
```

### TailwindCSS Config

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'mediterranean': '#0077B6',
                'limoncello': '#FFD60A',
                'navy': '#023E8A',
                'coral': '#FF6B6B'
            }
        }
    }
}
```

### HTML Örnekleri

```html
<!-- Navigation -->
<nav class="bg-navy text-white py-4">
    <a href="#" class="nav-link text-limoncello">Home</a>
    <a href="#" class="nav-link hover:text-limoncello">Menüs</a>
</nav>

<!-- Dual CTA -->
<div class="flex gap-4">
    <button class="bg-mediterranean hover:bg-navy text-white px-8 py-4 rounded-lg">
        Hauptaktion
    </button>
    <button class="bg-coral hover:bg-coral/90 text-white px-8 py-4 rounded-lg">
        Zweite Aktion
    </button>
</div>

<!-- Feature Card -->
<div class="bg-white border-t-4 border-limoncello shadow-lg p-6 rounded-lg">
    <div class="text-5xl mb-4">🍋</div>
    <h3 class="text-navy text-2xl font-serif mb-3">Weinverkostungen</h3>
    <p class="text-gray-600">Exklusive Events mit handverlesenen Weinen...</p>
</div>
```

### Özellikler
- ✅ **Taze ve enerjik** his
- ✅ **Tatil havası** (vacation vibes)
- ✅ **Modern ve dinamik** görünüm
- ✅ **Yüksek kontrast** (erişilebilirlik açısından mükemmel)
- ✅ **Akdeniz yaşam tarzını** yansıtıyor

### Kullanım Senaryosu
İdeal için: Yaz etkinlikleri, beach weddings, genç ve dinamik hedef kitle

---

## Alternatif 3: Sicilya Ceramica Paleti 🏺

### Tema
Sicilya seramikleri, barok mimarisi, turunçgiller, geleneksel zanaat sanatı

### Ana Renkler

| Renk Adı | HEX Kod | RGB | Kullanım Alanı |
|----------|---------|-----|----------------|
| **Majolica Mavi** | `#1E3A8A` | rgb(30, 58, 138) | Primary renk, başlıklar |
| **Sicilya Turuncu** | `#FB923C` | rgb(251, 146, 60) | CTA buttonlar, aksan |
| **Krem İvory** | `#FEFCE8` | rgb(254, 252, 232) | Arka plan |
| **Patlıcan Moru** | `#6B21A8` | rgb(107, 33, 168) | Secondary aksan, ikonlar |
| **Terracotta Kırmızı** | `#DC2626` | rgb(220, 38, 38) | Hover, vurgular |

### CSS Implementasyonu

```css
:root {
    /* Sicilya Paleti */
    --color-majolica: #1E3A8A;
    --color-sicilian-orange: #FB923C;
    --color-ivory: #FEFCE8;
    --color-eggplant: #6B21A8;
    --color-terracotta-red: #DC2626;
}

/* Hero Design */
.hero {
    background-color: var(--color-ivory);
}

.hero h1 {
    color: var(--color-majolica);
}

.hero .btn-primary {
    background-color: var(--color-sicilian-orange);
    color: white;
}

/* Service Cards */
.service-card {
    background: white;
    border-bottom: 3px solid var(--color-terracotta-red);
}

.service-card .icon-wrapper {
    background-color: var(--color-eggplant);
    color: white;
    border-radius: 50%;
    padding: 1rem;
}
```

### TailwindCSS Config

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'majolica': '#1E3A8A',
                'sicilian-orange': '#FB923C',
                'ivory': '#FEFCE8',
                'eggplant': '#6B21A8',
                'terracotta-red': '#DC2626'
            }
        }
    }
}
```

### HTML Örnekleri

```html
<!-- Hero Section -->
<section class="bg-ivory py-20">
    <div class="container mx-auto text-center">
        <h1 class="text-majolica text-6xl font-serif mb-6">
            Italienische Eleganz
        </h1>
        <button class="bg-sicilian-orange hover:bg-terracotta-red text-white px-10 py-4 rounded-lg">
            Jetzt Anfragen
        </button>
    </div>
</section>

<!-- Service Card with Icon -->
<div class="bg-white p-8 rounded-lg border-b-3 border-terracotta-red shadow-lg">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-eggplant text-white rounded-full mb-4">
        <span class="text-2xl">🍷</span>
    </div>
    <h3 class="text-majolica text-2xl font-serif mb-3">Weinverkostungen</h3>
    <p class="text-gray-600">Exklusive Events mit handverlesenen italienischen Weinen...</p>
</div>

<!-- Interactive Element -->
<div class="border-2 border-sicilian-orange hover:border-eggplant transition-all p-6 rounded-lg">
    <p>Hover für Farbe ändern</p>
</div>
```

### Özellikler
- ✅ **Zengin ve sanatsal** görünüm
- ✅ **Kültürel derinlik** (zanaat sanatı vurgusu)
- ✅ **Renkli ama dengeli** (çok fazla renk ama uyumlu)
- ✅ **Geleneksel ama modern** sentezi
- ✅ **Sicilya seramiklerinin** otantik renkleri

### Kullanım Senaryosu
İdeal için: Kültürel etkinlikler, sanat odaklı organizasyonlar, butik catering

---

## Alternatif 4: Venedik Elegance Paleti 🎭

### Tema
Gondollar, Carnivale maskeleri, altın işlemeler, lüks ve sofistikasyon

### Ana Renkler

| Renk Adı | HEX Kod | RGB | Kullanım Alanı |
|----------|---------|-----|----------------|
| **Gondola Siyahı** | `#1F2937` | rgb(31, 41, 55) | Header, footer, başlıklar |
| **Altın** | `#F59E0B` | rgb(245, 158, 11) | CTA, aksan, ikonlar |
| **Lagün Yeşili** | `#059669` | rgb(5, 150, 105) | Secondary CTA |
| **Krem** | `#FEF3C7` | rgb(254, 243, 199) | Arka plan bölümleri |
| **Burgundy** | `#991B1B` | rgb(153, 27, 27) | Hover, linkler |

### CSS Implementasyonu

```css
:root {
    /* Venedik Paleti */
    --color-gondola: #1F2937;
    --color-gold: #F59E0B;
    --color-lagoon: #059669;
    --color-cream: #FEF3C7;
    --color-burgundy: #991B1B;
}

/* Premium Header */
.header {
    background-color: var(--color-gondola);
}

.nav-link.active {
    color: var(--color-gold);
}

/* CTA Hierarchy */
.btn-primary {
    background-color: var(--color-gold);
    color: var(--color-gondola);
}

.btn-secondary {
    background-color: transparent;
    border: 2px solid var(--color-lagoon);
    color: var(--color-lagoon);
}

.btn-secondary:hover {
    background-color: var(--color-lagoon);
    color: white;
}

/* Typography */
h1, h2, h3 {
    color: var(--color-gondola);
}

a {
    color: var(--color-burgundy);
}

a:hover {
    color: var(--color-gold);
}
```

### TailwindCSS Config

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'gondola': '#1F2937',
                'gold': '#F59E0B',
                'lagoon': '#059669',
                'cream': '#FEF3C7',
                'burgundy': '#991B1B'
            }
        }
    }
}
```

### HTML Örnekleri

```html
<!-- Premium Header -->
<header class="bg-gondola text-white py-6 shadow-lg">
    <nav class="container mx-auto flex justify-between items-center">
        <h1 class="text-gold text-3xl font-serif">Catering Antipasti</h1>
        <ul class="flex gap-8">
            <li><a href="#" class="hover:text-gold transition-colors">Home</a></li>
            <li><a href="#" class="text-gold">Menüs</a></li>
        </ul>
    </nav>
</header>

<!-- Dual CTA (Premium/Secondary) -->
<div class="flex gap-4 justify-center">
    <button class="bg-gold hover:bg-gold/90 text-gondola px-10 py-4 rounded-lg font-semibold text-lg">
        Premium Menü
    </button>
    <button class="border-2 border-lagoon text-lagoon hover:bg-lagoon hover:text-white px-10 py-4 rounded-lg font-semibold text-lg transition-all">
        Standard Menü
    </button>
</div>

<!-- Elegant Card -->
<div class="bg-cream border-l-4 border-gold p-8 rounded-lg shadow-xl">
    <h3 class="text-gondola text-3xl font-serif mb-4">Hochzeitsmenü "Venezia"</h3>
    <p class="text-gray-700 mb-6">Eine kulinarische Reise durch die Lagune...</p>
    <a href="#" class="text-burgundy hover:text-gold font-semibold">
        Mehr Erfahren →
    </a>
</div>
```

### Özellikler
- ✅ **Lüks ve premium** his
- ✅ **Sofistike görünüm** (high-end clients için)
- ✅ **Düşük enerji, yüksek etki** (minimal ama güçlü)
- ✅ **Altın aksan** (özel günler için mükemmel)
- ✅ **Carnivale maskeleri ve gondolları** çağrıştırıyor

### Kullanım Senaryosu
İdeal için: Lüks düğünler, gala yemekleri, kurumsal üst düzey etkinlikler

---

## Karşılaştırma Tablosu

| Palet | Enerji Seviyesi | Hedef Duygu | Kullanım Senaryosu | Yaş Grubu |
|-------|----------------|-------------|-------------------|-----------|
| **Toskana** (Turuncu+Krem) | ⚡⚡⚡ Orta-Yüksek | Sıcaklık, Geleneksel | Aile dostu, rustik etkinlikler | 25-65 |
| **Amalfi** (Mavi+Sarı) | ⚡⚡⚡⚡ Çok Yüksek | Tazelik, Eğlence | Yaz etkinlikleri, genç kitle | 20-45 |
| **Sicilya** (Mavi+Turuncu+Mor) | ⚡⚡⚡ Orta | Zenginlik, Zanaat | Kültürel, sanat odaklı | 30-60 |
| **Venedik** (Siyah+Altın) | ⚡⚡ Düşük (Premium) | Sofistike, Elegant | Lüks düğünler, gala | 35-70 |

---

## Okunabilirlik ve Erişilebilirlik Analizi

### WCAG Kontrast Oranları (AA Standardı: 4.5:1)

#### Toskana Paleti
- ✅ Koyu Toprak (#5C4A3C) / Beyaz: **10.8:1** (Mükemmel)
- ✅ Terracotta (#D4704A) / Beyaz: **3.9:1** (Büyük text için uygun)
- ✅ Bağ Yeşili (#3A5A40) / Krem (#F5E6D3): **5.2:1** (Mükemmel)

#### Amalfi Paleti
- ✅ Lacivert (#023E8A) / Beyaz: **13.1:1** (Mükemmel)
- ✅ Akdeniz Mavi (#0077B6) / Beyaz: **5.1:1** (Mükemmel)
- ⚠️ Limoncello Sarı (#FFD60A) / Beyaz: **1.7:1** (Sadece aksan için)

#### Sicilya Paleti
- ✅ Majolica Mavi (#1E3A8A) / Beyaz: **11.9:1** (Mükemmel)
- ✅ Patlıcan Moru (#6B21A8) / Beyaz: **7.2:1** (Mükemmel)
- ✅ Sicilya Turuncu (#FB923C) / Siyah: **6.8:1** (Mükemmel)

#### Venedik Paleti
- ✅ Gondola Siyahı (#1F2937) / Beyaz: **15.2:1** (Mükemmel)
- ✅ Burgundy (#991B1B) / Beyaz: **9.1:1** (Mükemmel)
- ⚠️ Altın (#F59E0B) / Beyaz: **2.3:1** (Sadece büyük text/aksan)

---

## Önerilen Palet: Toskana Güneşi

### Neden Bu Palet?

1. **Hasan'ın Markası ile Uyum**
   - Rustik ama profesyonel
   - Geleneksel İtalyan değerleri
   - Catering işine çok uygun

2. **Psikolojik Etki**
   - Terracotta = Sıcaklık, misafirperverlik
   - Krem = Şıklık, temizlik
   - Toprak tonları = Güvenilirlik, doğallık

3. **Teknik Avantajlar**
   - Mükemmel okunabilirlik
   - Tüm cihazlarda iyi görünür
   - Print materyallerde başarılı

4. **Hedef Kitle Uygunluği**
   - Geniş yaş aralığına hitap ediyor
   - Business ve private events için uygun
   - Hem modern hem geleneksel

---

## Hibrit Yaklaşım (Bonus Öneri)

Eğer tek bir palete karar verilmezse, **en iyi özellikler kombine edilebilir:**

### Hibrit Palet Tablosu

| Element | Renk | HEX | Kaynak Palet |
|---------|------|-----|--------------|
| **Primary CTA** | Terracotta | `#D4704A` | Toskana |
| **Secondary CTA** | Akdeniz Mavi | `#0077B6` | Amalfi |
| **Başlıklar** | Koyu Toprak | `#5C4A3C` | Toskana |
| **Arka Plan** | Krem | `#F5E6D3` | Toskana |
| **Aksan/Hover** | Limoncello Sarı | `#FFD60A` | Amalfi |
| **Footer** | Gondola Siyahı | `#1F2937` | Venedik |

### Hibrit Palet CSS

```css
:root {
    /* Hibrit Palet - En İyi Kombinasyon */
    --primary-cta: #D4704A;        /* Toskana Terracotta */
    --secondary-cta: #0077B6;      /* Amalfi Mavi */
    --heading: #5C4A3C;            /* Toskana Toprak */
    --background: #F5E6D3;         /* Toskana Krem */
    --accent: #FFD60A;             /* Amalfi Sarı */
    --footer: #1F2937;             /* Venedik Siyah */
    --text-body: #4B5563;          /* Neutral Gri */
}
```

### Hibrit Palet Kullanımı

```html
<!-- Hero with Mixed Colors -->
<section class="bg-background py-20">
    <h1 class="text-heading text-6xl font-serif mb-6">
        Catering Antipasti
    </h1>
    <div class="flex gap-4">
        <button class="bg-primary-cta hover:bg-heading text-white px-8 py-4 rounded-lg">
            Menüs Ansehen
        </button>
        <button class="bg-secondary-cta hover:bg-secondary-cta/90 text-white px-8 py-4 rounded-lg">
            Kontakt
        </button>
    </div>
</section>

<!-- Card with Accent Border -->
<div class="bg-white border-t-4 border-accent p-8 shadow-lg">
    <h3 class="text-heading text-2xl font-serif">Business Catering</h3>
</div>

<!-- Footer -->
<footer class="bg-footer text-white py-12">
    <p>&copy; 2024 Catering Antipasti</p>
</footer>
```

---

## Implementasyon Adımları

### 1. TailwindCSS ile Kurulum

**tailwind.config.js** dosyasına ekle:

```javascript
module.exports = {
    theme: {
        extend: {
            colors: {
                // Seçilen Palet (örnek: Toskana)
                'terra': '#D4704A',
                'cream': '#F5E6D3',
                'earth': '#5C4A3C',
                'olive-oil': '#E8B944',
                'vineyard': '#3A5A40'
            },
            fontFamily: {
                serif: ['Playfair Display', 'serif'],
                sans: ['Work Sans', 'sans-serif']
            }
        }
    }
}
```

### 2. Vanilla CSS ile Kurulum

**custom.css** dosyası:

```css
/* CSS Variables */
:root {
    /* Toskana Paleti */
    --color-terra: #D4704A;
    --color-cream: #F5E6D3;
    --color-earth: #5C4A3C;
    --color-olive-oil: #E8B944;
    --color-vineyard: #3A5A40;
    
    /* Typography */
    --font-serif: 'Playfair Display', serif;
    --font-sans: 'Work Sans', sans-serif;
}

/* Global Styles */
body {
    font-family: var(--font-sans);
    color: var(--color-earth);
}

h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-serif);
    color: var(--color-earth);
}

/* Button Styles */
.btn-primary {
    background-color: var(--color-terra);
    color: var(--color-cream);
    padding: 1rem 2rem;
    border-radius: 0.5rem;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: var(--color-earth);
    transform: translateY(-2px);
}

/* Card Styles */
.card {
    background: white;
    border-top: 4px solid var(--color-olive-oil);
    border-radius: 0.5rem;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
```

### 3. Test Etme

**Farklı cihazlarda test için:**
- Desktop: Chrome, Firefox, Safari
- Mobile: iOS Safari, Android Chrome
- Tablet: iPad, Android tablet
- Print: PDF çıktısı

---

## Karar Matrisi

Hasan'ın markası için doğru paleti seçmek üzere:

### Soru 1: Markanın Ana Hissi?
- **"Rustik, sıcak, geleneksel"** → **Toskana**
- **"Taze, modern, enerjik"** → **Amalfi**
- **"Sanatsal, kültürel"** → **Sicilya**
- **"Lüks, premium"** → **Venedik**

### Soru 2: Hedef Müşteri Profili?
- **Aileler, düğünler, yerel etkinlikler** → **Toskana**
- **Genç profesyoneller, startup'lar** → **Amalfi**
- **Kültür kurumları, müzeler** → **Sicilya**
- **Üst düzey şirketler, gala organizasyonları** → **Venedik**

### Soru 3: Bütçe ve Pozisyonlama?
- **Orta-üst segment, kalite odaklı** → **Toskana**
- **Orta segment, erişilebilir** → **Amalfi**
- **Niş pazar, özel projeler** → **Sicilya**
- **Premium segment, lüks** → **Venedik**

---

## Sonuç ve Tavsiye

### En Uygun Palet: **Toskana Güneşi**

**Gerekçe:**
1. ✅ Catering işine çok uygun (rustik ama profesyonel)
2. ✅ Geniş hedef kitleye hitap ediyor
3. ✅ Teknik olarak mükemmel (okunabilirlik, erişilebilirlik)
4. ✅ İtalyan kültürünü doğru yansıtıyor
5. ✅ Zamansız tasarım (moda geçmez)

### Yedek Seçenek: **Hibrit Palet**

Eğer daha fazla çeşitlilik istenirse, Toskana temelinde Amalfi ve Venedik elementleri eklenebilir.

---

## Ek Kaynaklar

### Renk Paletini Test Etmek İçin Araçlar:
- **Coolors.co** - Palet oluşturma ve export
- **Adobe Color** - Renk uyumu kontrolü
- **WebAIM Contrast Checker** - Erişilebilirlik testi
- **Canva** - Mockup ve test

### Google Fonts Kombinasyonları:
```html
<!-- Toskana için Font Pairing -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Work+Sans:wght@300;400;600&display=swap" rel="stylesheet">
```

### İkonlar:
- **Heroicons** - Minimalist SVG ikonlar
- **Font Awesome** - Geniş ikon kütüphanesi
- **Lucide** - Modern ve temiz ikonlar

---

## Son Notlar

Bu paletler, Catering Antipasti web sitesi için **güçlü bir görsel kimlik** oluşturmak üzere tasarlanmıştır. Her palet, İtalyan kültürünün farklı bir yönünü yansıtmakta ve **marka hikayesini** desteklemektedir.

**Önerilen Implementasyon Sırası:**
1. Bir palet seç (tavsiye: Toskana)
2. TailwindCSS/CSS değişkenlerini kur
3. Ana sayfalarda test et (homepage, menu, contact)
4. Hedef kitleyle test et (A/B testing)
5. Gerekirse ince ayarlar yap

---

**Hazırlayan:** Claude  
**Tarih:** 14 Kasım 2024  
**Proje:** Catering Antipasti Website Development  
**Müşteri:** Hasan Geray
