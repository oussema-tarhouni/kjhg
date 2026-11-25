import { boot } from './eos-runtime.js';
class LandingComponent {
    // Handles data-action/data-arg clicks (replaces original inline onclick="" attributes,
    // which Angular's template compiler disallows for security reasons)
    __run(event) {
        const el = event.currentTarget;
        const action = el.dataset['action'];
        const arg = el.dataset['arg'];
        if (action === 'toggleParentOpen') {
            el.parentElement?.classList.toggle('open');
            return;
        }
        if (action && typeof window[action] === 'function') {
            window[action](arg, el);
        }
    }
    ngAfterViewInit() {
        document.documentElement.setAttribute('data-theme', 'dark');
        const nav = document.getElementById('nav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('is-scrolled', window.scrollY > 20);
        });
        function switchPlan(tab, btn) {
            document.querySelectorAll('.plans__tab').forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            document.querySelectorAll('.plans__panel').forEach(p => p.classList.remove('is-active'));
            document.getElementById('panel-' + tab).classList.add('is-active');
        }
        const I18N = {
            en: { flag: '🇬🇧', code: 'EN', dir: 'ltr', t: {
                    'nav.about': 'About', 'nav.programs': 'Programs', 'nav.plans': 'Plans', 'nav.locations': 'Locations', 'nav.membership': 'Membership', 'nav.login': 'Log In', 'nav.join': 'Join Now',
                    'hero.eyebrow': 'Strength · Pilates · Community', 'hero.title': 'Train like the<br>work actually <span>matters</span>',
                    'hero.lead': 'Free weights, a reformer pilates studio, and group classes under one roof — with a front desk that actually remembers your name. Open early, open late, three floors near you.',
                    'hero.findLocation': 'Find a Location', 'hero.scroll': 'Scroll',
                    'stats.members': 'Active Members', 'stats.classes': 'Classes Weekly', 'stats.locations': 'Locations', 'stats.hours': 'Daily Hours',
                    'about.eyebrow': 'About Us', 'about.title': 'A gym built by people who actually train here',
                    'about.p1': "EOS started as a single strength floor and a stubborn belief that a gym should feel like it belongs to its members, not the other way around. A decade later that hasn't changed — the same coaches who designed the programming are still on the floor spotting sets and correcting form.",
                    'about.p2': 'We built three things under one roof: a serious free-weight and machine floor, a reformer pilates studio led by instructors who watch every rep, and a class schedule people actually show up for. No matter which door you walk through, someone knows your name and your goals.',
                    'about.badge.title': 'Est. 2014', 'about.badge.sub': 'Locally owned, still coached',
                    'about.pillar1.title': 'Strength Floor', 'about.pillar1.desc': 'Free weights &amp; machines, zero waiting.',
                    'about.pillar2.title': 'Pilates Studio', 'about.pillar2.desc': 'Reformer &amp; mat, small class sizes.',
                    'about.pillar3.title': 'Community', 'about.pillar3.desc': 'Members-only app &amp; real front desk.',
                    'team.eyebrow': 'Meet The Team', 'team.title': 'Administration &amp; Coaches',
                    'team.gm': 'General Manager', 'team.ops': 'Operations Director', 'team.strength': 'Head Strength Coach', 'team.pilates': 'Pilates Instructor', 'team.group': 'Group Fitness Coach', 'team.nutrition': 'Nutrition Coach',
                    'programs.eyebrow': 'Programs', 'programs.title': 'Train your way', 'programs.lead': 'Three floors, one membership. Move between them as your training changes.',
                    'programs.c1.tag': 'Strength', 'programs.c1.title': 'Strength &amp; Conditioning', 'programs.c1.desc': 'A full floor of free weights, plate-loaded machines, and platforms for serious lifting — plus programming if you want it.',
                    'programs.c2.tag': 'Pilates', 'programs.c2.title': 'Reformer &amp; Mat Pilates', 'programs.c2.desc': 'Small classes led by instructors who watch your form rep by rep — reformer, mat, and everything between.',
                    'programs.c3.tag': 'Group Classes', 'programs.c3.title': 'HIIT, Cycle &amp; More', 'programs.c3.desc': '40+ classes a week across every floor. Book your spot in the app before it fills up.',
                    'plans.eyebrow': 'Plans', 'plans.title': 'Pricing built to move you', 'plans.lead': 'Strength, pilates, or both — pick your track. Promo prices shown where available.',
                    'plans.tabMusc': 'Musculation', 'plans.tabPilates': 'Pilates', 'plans.membership': 'Membership', 'plans.privateCoaching': 'Private Coaching', 'plans.dropIn': 'Drop-in floor session — 10 DT',
                    'plans.essentiel': 'Reformer — Essentiel', 'plans.premium': 'Reformer + Privé — Premium', 'plans.integral': 'Pilates + Musculation — Intégral', 'plans.privateSessions': 'Private Sessions', 'plans.rpLegend': 'R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)',
                    'banner.title': 'A gym that knows your name', 'banner.text': 'Group classes, a members-only app, and a front desk that remembers your goals — not just your card number.',
                    'locations.eyebrow': 'Location', 'locations.title': 'Find us on the map', 'locations.lead': 'One floor, open early, open late. Drop in whenever training calls.',
                    'locations.addr': 'Fitness &amp; Pilates<br>Bizerte Governorate, Tunisia', 'locations.weekdays': 'Weekdays', 'locations.weekends': 'Weekends', 'locations.directions': 'Get Directions',
                    'cta.title': 'Your first rep starts here', 'cta.text': 'Create a free account and set up your membership in under a minute — book classes, track workouts, and manage everything from the app.',
                    'foot.tagline': 'Strength, pilates, and group classes across three floors — built for people who actually train.',
                    'foot.explore': 'Explore', 'foot.account': 'Account', 'foot.schedule': 'Class Schedule', 'foot.contact': 'Contact', 'foot.rights': '© 2026 EOS Fitness &amp; Pilates. All rights reserved.'
                } },
            fr: { flag: '🇫🇷', code: 'FR', dir: 'ltr', t: {
                    'nav.about': 'À propos', 'nav.programs': 'Programmes', 'nav.plans': 'Forfaits', 'nav.locations': 'Salles', 'nav.membership': 'Adhésion', 'nav.login': 'Connexion', 'nav.join': 'Rejoindre',
                    'hero.eyebrow': 'Force · Pilates · Communauté', 'hero.title': "Entraîne-toi comme si<br>chaque effort <span>comptait</span>",
                    'hero.lead': "Poids libres, studio de pilates reformer et cours collectifs sous un même toit — avec un accueil qui se souvient de votre nom. Ouvert tôt, ouvert tard, trois étages près de chez vous.",
                    'hero.findLocation': 'Trouver une salle', 'hero.scroll': 'Défiler',
                    'stats.members': 'Membres actifs', 'stats.classes': 'Cours par semaine', 'stats.locations': 'Salles', 'stats.hours': 'Horaires quotidiens',
                    'about.eyebrow': 'À propos', 'about.title': 'Une salle construite par des gens qui s\'entraînent vraiment ici',
                    'about.p1': "EOS a commencé comme un seul plateau de musculation et une conviction tenace : une salle doit appartenir à ses membres, pas l'inverse. Dix ans plus tard, rien n'a changé — les mêmes coachs qui ont conçu les programmes sont toujours là à corriger vos mouvements.",
                    'about.p2': "Nous avons réuni trois espaces sous un même toit : un vrai plateau de poids libres et machines, un studio de pilates reformer où les instructeurs surveillent chaque répétition, et un planning de cours que les gens suivent vraiment. Peu importe la porte que vous franchissez, quelqu'un connaît votre nom et vos objectifs.",
                    'about.badge.title': 'Depuis 2025', 'about.badge.sub': 'Propriété locale, toujours coachée',
                    'about.pillar1.title': 'Plateau Musculation', 'about.pillar1.desc': 'Poids libres &amp; machines, zéro attente.',
                    'about.pillar2.title': 'Studio Pilates', 'about.pillar2.desc': 'Reformer &amp; tapis, petits groupes.',
                    'about.pillar3.title': 'Communauté', 'about.pillar3.desc': 'App membres &amp; vrai accueil.',
                    'team.eyebrow': 'L\'équipe', 'team.title': 'Administration &amp; Coachs',
                    'team.gm': 'Directeur Général', 'team.ops': 'Directrice des Opérations', 'team.strength': 'Coach Principal Musculation', 'team.pilates': 'Instructrice Pilates', 'team.group': 'Coach Cours Collectifs', 'team.nutrition': 'Coach Nutrition',
                    'programs.eyebrow': 'Programmes', 'programs.title': 'Entraîne-toi à ta façon', 'programs.lead': 'Trois étages, un seul abonnement. Passez de l\'un à l\'autre selon votre entraînement.',
                    'programs.c1.tag': 'Force', 'programs.c1.title': 'Musculation &amp; Préparation physique', 'programs.c1.desc': 'Un plateau complet de poids libres, machines guidées et plateformes pour lever sérieusement — avec programmation si vous le souhaitez.',
                    'programs.c2.tag': 'Pilates', 'programs.c2.title': 'Reformer &amp; Pilates Tapis', 'programs.c2.desc': 'Petits groupes encadrés par des instructeurs qui surveillent chaque mouvement — reformer, tapis, et tout le reste.',
                    'programs.c3.tag': 'Cours collectifs', 'programs.c3.title': 'HIIT, Cycle &amp; Plus', 'programs.c3.desc': 'Plus de 40 cours par semaine sur tous les étages. Réservez votre place sur l\'app avant qu\'elle ne soit complète.',
                    'plans.eyebrow': 'Forfaits', 'plans.title': 'Des tarifs faits pour vous faire bouger', 'plans.lead': 'Musculation, pilates, ou les deux — choisissez votre voie. Tarifs promo affichés quand disponibles.',
                    'plans.tabMusc': 'Musculation', 'plans.tabPilates': 'Pilates', 'plans.membership': 'Abonnement', 'plans.privateCoaching': 'Coaching privé', 'plans.dropIn': 'Séance à la carte — 10 DT',
                    'plans.essentiel': 'Reformer — Essentiel', 'plans.premium': 'Reformer + Privé — Premium', 'plans.integral': 'Pilates + Musculation — Intégral', 'plans.privateSessions': 'Séances privées', 'plans.rpLegend': 'R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)',
                    'banner.title': 'Une salle qui connaît votre nom', 'banner.text': 'Cours collectifs, application réservée aux membres, et un accueil qui se souvient de vos objectifs — pas seulement de votre numéro de carte.',
                    'locations.eyebrow': 'Salle', 'locations.title': 'Trouvez-nous sur la carte', 'locations.lead': 'Un seul étage, ouvert tôt, ouvert tard. Passez dès que l\'entraînement vous appelle.',
                    'locations.addr': 'Fitness &amp; Pilates<br>Gouvernorat de Bizerte, Tunisie', 'locations.weekdays': 'Semaine', 'locations.weekends': 'Week-end', 'locations.directions': 'Itinéraire',
                    'cta.title': 'Votre première répétition commence ici', 'cta.text': 'Créez un compte gratuit et configurez votre abonnement en moins d\'une minute — réservez vos cours, suivez vos séances, et gérez tout depuis l\'app.',
                    'foot.tagline': 'Musculation, pilates et cours collectifs sur trois étages — pensé pour ceux qui s\'entraînent vraiment.',
                    'foot.explore': 'Explorer', 'foot.account': 'Compte', 'foot.schedule': 'Planning des cours', 'foot.contact': 'Contact', 'foot.rights': '© 2026 EOS Fitness &amp; Pilates. Tous droits réservés.'
                } },
            tn: { flag: '🇹🇳', code: 'TN', dir: 'rtl', t: {
                    'nav.about': 'علينا', 'nav.programs': 'البرامج', 'nav.plans': 'الاشتراكات', 'nav.locations': 'الفروع', 'nav.membership': 'العضوية', 'nav.login': 'دخول', 'nav.join': 'انضم توا',
                    'hero.eyebrow': 'قوة · بيلاتس · جماعة', 'hero.title': 'تدرب كيف <span>يستاهل</span><br>الجهد الي تعمله',
                    'hero.lead': 'أثقال حرة، استوديو بيلاتس، وحصص جماعية في نفس المكان — وريسبسيون يعرفك بالاسم. نحلو بكري ونسكرو مالطول، تلاتة طوابق قريبين منك.',
                    'hero.findLocation': 'لوّج على فرع', 'hero.scroll': 'إنزل',
                    'stats.members': 'مشترك ناشط', 'stats.classes': 'حصة في الجمعة', 'stats.locations': 'فروع', 'stats.hours': 'توقيت اليوم',
                    'about.eyebrow': 'علينا', 'about.title': 'صالة بناها ناس يتدربو فيها بالزاف',
                    'about.p1': 'EOS بدات بطابق وحيد للأثقال وفكرة ثابتة: الصالة لازم تكون ملك للمشتركين، موش العكس. بعد عشرية، الحكاية ما تبدلتش — نفس الكوتشات الي حطو البرامج مازالو يراقبو الحركات ويصححو الوضعية.',
                    'about.p2': 'جمعنا تلاتة حاجات في نفس المكان: طابق جدي للأثقال الحرة والمكينات، استوديو بيلاتس يراقب فيه المدرب كل حركة، وبرنامج حصص الناس تحضرو بالزاف. من أي باب تدخل، فما شكون يعرف اسمك وأهدافك.',
                    'about.badge.title': 'من 2014', 'about.badge.sub': 'ملكية محلية، مازالت متكوتشة',
                    'about.pillar1.title': 'طابق الأثقال', 'about.pillar1.desc': 'أثقال حرة &amp; مكينات، بلا انتظار.',
                    'about.pillar2.title': 'استوديو بيلاتس', 'about.pillar2.desc': 'ريفورمر &amp; ماط، مجموعات صغيرة.',
                    'about.pillar3.title': 'جماعة', 'about.pillar3.desc': 'أپليكاسيون للمشتركين &amp; ريسبسيون حقيقي.',
                    'team.eyebrow': 'الفريق', 'team.title': 'الإدارة و الكوتشات',
                    'team.gm': 'مدير عام', 'team.ops': 'مديرة العمليات', 'team.strength': 'كوتش رئيسي للأثقال', 'team.pilates': 'مدربة بيلاتس', 'team.group': 'كوتش حصص جماعية', 'team.nutrition': 'كوتش تغذية',
                    'programs.eyebrow': 'البرامج', 'programs.title': 'تدرب بالطريقة الي تحبها', 'programs.lead': 'تلاتة طوابق، اشتراك واحد. بدل بينهم كيفما يتبدل التدريب متاعك.',
                    'programs.c1.tag': 'قوة', 'programs.c1.title': 'مسكلة &amp; تكييف بدني', 'programs.c1.desc': 'طابق كامل بالأثقال الحرة والمكينات والمنصات باش ترفع بجدية — مع برنامج إذا حبيت.',
                    'programs.c2.tag': 'بيلاتس', 'programs.c2.title': 'ريفورمر &amp; بيلاتس ماط', 'programs.c2.desc': 'مجموعات صغيرة يراقب فيها المدرب كل حركة — ريفورمر، ماط، وكل شي بينهم.',
                    'programs.c3.tag': 'حصص جماعية', 'programs.c3.title': 'HIIT، سيكل &amp; أكثر', 'programs.c3.desc': 'أكثر من 40 حصة في الجمعة في كل الطوابق. احجز بلاصتك في الأپليكاسيون قبل ما تكمل.',
                    'plans.eyebrow': 'الاشتراكات', 'plans.title': 'أسعار تعملك تتحرك', 'plans.lead': 'مسكلة، بيلاتس، ولا الزوز فما — اختار الطريق متاعك. أسعار البرومو موجودة وين تلقاها.',
                    'plans.tabMusc': 'مسكلة', 'plans.tabPilates': 'بيلاتس', 'plans.membership': 'اشتراك', 'plans.privateCoaching': 'كوتشينڨ خاص', 'plans.dropIn': 'حصة وحدة بلا اشتراك — 10 دت',
                    'plans.essentiel': 'ريفورمر — أساسي', 'plans.premium': 'ريفورمر + خاص — بريميوم', 'plans.integral': 'بيلاتس + مسكلة — شامل', 'plans.privateSessions': 'حصص خاصة', 'plans.rpLegend': 'R = ريفورمر &nbsp; P = خاص (كاديلاك، وندا تشير، باريل، تاور)',
                    'banner.title': 'صالة تعرف اسمك', 'banner.text': 'حصص جماعية، أپليكاسيون للمشتركين، وريسبسيون يتفكر أهدافك — موش غير رقم الكارت متاعك.',
                    'locations.eyebrow': 'الفرع', 'locations.title': 'لقانا على الخريطة', 'locations.lead': 'طابق واحد، نحلو بكري ونسكرو مالطول. اجي أي وقت تحس بالتدريب.',
                    'locations.addr': 'فيتنس &amp; بيلاتس<br>ولاية بنزرت، تونس', 'locations.weekdays': 'أيام الجمعة', 'locations.weekends': 'ويكاند', 'locations.directions': 'الطريق للفرع',
                    'cta.title': 'أول ركعة تبدا من هنا', 'cta.text': 'اعمل حساب فيه الفري وحضر الاشتراك متاعك في أقل من دقيقة — احجز الحصص، تابع التمارين، وقس كل شي من الأپليكاسيون.',
                    'foot.tagline': 'مسكلة، بيلاتس، وحصص جماعية في تلاتة طوابق — معمولة لناس يتدربو بالزاف.',
                    'foot.explore': 'استكشف', 'foot.account': 'الحساب', 'foot.schedule': 'برنامج الحصص', 'foot.contact': 'اتصل بينا', 'foot.rights': '© 2026 EOS Fitness &amp; Pilates. جميع الحقوق محفوظة.'
                } }
        };
        function applyLang(code) {
            const L = I18N[code] || I18N.en;
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (L.t[key])
                    el.innerHTML = L.t[key];
            });
            document.getElementById('lang-flag').textContent = L.flag;
            document.getElementById('lang-code').textContent = L.code;
            document.documentElement.setAttribute('dir', L.dir);
            document.documentElement.setAttribute('lang', code);
            localStorage.setItem('eos-lang', code);
        }
        const burger = document.getElementById('nav-burger');
        const mobileMenu = document.getElementById('mobile-menu');
        burger.addEventListener('click', () => {
            burger.classList.toggle('open');
            mobileMenu.classList.toggle('open');
        });
        mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
            burger.classList.remove('open');
            mobileMenu.classList.remove('open');
        }));
        const btn = document.getElementById('lang-btn');
        const menu = document.getElementById('lang-menu');
        btn.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('open'); });
        document.addEventListener('click', () => menu.classList.remove('open'));
        menu.querySelectorAll('button[data-lang]').forEach(b => {
            b.addEventListener('click', () => { applyLang(b.dataset.lang); menu.classList.remove('open'); });
        });
        applyLang(localStorage.getItem('eos-lang') || 'en');
        // expose functions referenced by data-action bindings in the template
        window['switchPlan'] = switchPlan;
    }
}

boot(LandingComponent, []);
