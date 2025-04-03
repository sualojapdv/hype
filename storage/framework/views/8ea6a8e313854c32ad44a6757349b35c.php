<!DOCTYPE html>
<html lang="zn-CN" data-data="网站主体" data-version="<?php echo e(now()->toString()); ?>" class="网站主体" data-city="São Paulo/Brazil" data-developer="daanrox.com">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
        <?php $setting = \Helper::getSetting() ?>
        <?php if(!empty($setting['software_favicon'])): ?>
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/storage/' . $setting['software_favicon'])); ?>">
        <?php endif; ?>

        <?php if(isset($setting['software_favicon'])): ?>
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/storage/' . $setting['software_favicon'])); ?>">
        <?php else: ?>
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/storage/rox/tJ9iWty5FUFg9V2XdLNgoLkTHfqPVnvN8hPBBBCV.png')); ?>">
        <?php endif; ?>

        <link rel="stylesheet" href="<?php echo e(asset('assets/css/fontawesome.min.css')); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100&display=swap" rel="stylesheet">
        <title><?php echo e(env('APP_NAME')); ?></title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <?php $custom = \Helper::getCustom() ?>
        <script>
            var customData = <?php echo json_encode($custom, 15, 512) ?>; 
            localStorage.setItem('customData', JSON.stringify(customData));
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Função para buscar parâmetros da URL
                function getQueryParams() {
                    const params = {};
                    const queryString = window.location.search.substring(1);
                    const pairs = queryString.split("&");
                    for (let i = 0; i < pairs.length; i++) {
                        const pair = pairs[i].split("=");
                        params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
                    }
                    return params;
                }

                // Busca o parâmetro 'code' e salva no localStorage
                const params = getQueryParams();
                if (params.code) {
                    localStorage.setItem('code', params.code);
                }
            });
        </script>

        <style>
            body{
                /* font-family: <?php echo e($custom['font_family_default'] ?? "'Roboto Condensed', sans-serif"); ?>; */
            }
            :root {
                --ci-primary-color: <?php echo e($custom['primary_color']); ?>;
                --ci-primary-opacity-color: <?php echo e($custom['primary_opacity_color']); ?>;
                --ci-secundary-color: <?php echo e($custom['secundary_color']); ?>;
                --ci-gray-dark: <?php echo e($custom['gray_dark_color']); ?>;
                --ci-gray-light: <?php echo e($custom['gray_light_color']); ?>;
                --ci-gray-medium: <?php echo e($custom['gray_medium_color']); ?>;
                --ci-gray-over: <?php echo e($custom['gray_over_color']); ?>;
                --title-color: <?php echo e($custom['title_color']); ?>;
                --text-color: <?php echo e($custom['text_color']); ?>;
                --sub-text-color: <?php echo e($custom['sub_text_color']); ?>;
                --side-menu-color: <?php echo e($custom['side_menu']); ?>;
                --placeholder-color: <?php echo e($custom['placeholder_color']); ?>;
                --background-color: <?php echo e($custom['background_color']); ?>;
                --background-base: <?php echo e($custom['background_base']); ?>;
                --standard-color: #1C1E22;
                --shadow-color: #111415;
                --page-shadow: linear-gradient(to right, #111415, rgba(17, 20, 21, 0));
                --autofill-color: #f5f6f7;
                --yellow-color: #FFBF39;
                --yellow-dark-color: #d7a026;
                --border-radius: <?php echo e($custom['border_radius']); ?>;
            }
            .navtop-color{
                background-color: <?php echo e($custom['primary_color']); ?> !important;
            }
            :is(.dark .navtop-color) {
                background-color: <?php echo e($custom['primary_color']); ?> !important;
            }

            .bg-base {
                background-image: url('/storage/rox/2-1-11.png') !important;
                background-repeat: repeat;
                background-size: auto;
                background-color: <?php echo e($custom['background_base']); ?> !important;
            }
            :is(.dark .bg-base) {
                background-image: url('/storage/rox/2-1-11.png') !important;
                background-repeat: repeat;
                background-size: auto;
                background-color: <?php echo e($custom['background_base_dark']); ?> !important;
            }
        </style>
        

        <?php if(!empty($custom['custom_css'])): ?>
            <style>
                <?php echo $custom['custom_css']; ?>

            </style>
        <?php endif; ?>

        <?php if(!empty($custom['custom_header'])): ?>
            <?php echo $custom['custom_header']; ?>

        <?php endif; ?>

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>

    <body id="罗克斯系统" color-theme="dark" class="bg-base text-gray-800 dark:text-gray-300">
        <div class="scroll-container">
            <div id="顶部"></div>
            <div id="daanrox" class="网站主体"></div>
            <div class="scroll-container"></div>
        </div>

        <script>
            window.Livewire?.on('copiado', (texto) => {
                navigator.clipboard.writeText(texto).then(() => {
                    Livewire.emit('copiado');
                });
            });

            window._token = '<?php echo e(csrf_token()); ?>';

            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            } else {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            }

            console.log('由 daanrox.com 开发');
            localStorage.setItem('developer', 'daanrox.com');
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const key = "<?php echo e(env('KEY')); ?>";
                localStorage.setItem('k', key);
                const wL = "<?php echo e(env('WHITELIST')); ?>";
                localStorage.setItem('whitelist', wL);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const scrollingText = "<?php echo e(env('SCROLLING_TEXT')); ?>";
                localStorage.setItem('scrollingText', scrollingText);
            });
        </script>

        <?php if(!empty($custom['custom_body'])): ?>
            <?php echo $custom['custom_body']; ?>

        <?php endif; ?>

        <?php if(!empty($custom)): ?>
            <script>
                const custom = <?php echo json_encode($custom); ?>;
            </script>
        <?php endif; ?>

        <noscript>
            <?php echo e(env('WHITELIST')); ?>

        </noscript>

        <!-- Removei o script que bloqueia o uso de DevTools -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <style>
            @media screen and (max-width: 1px) {
                body {
                    display: none;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let loadingScreen = document.createElement('div');
                loadingScreen.style.position = 'fixed';
                loadingScreen.style.top = '0';
                loadingScreen.style.left = '0';
                loadingScreen.style.width = '100vw';
                loadingScreen.style.height = '100vh';
                loadingScreen.style.backgroundColor = 'var(--ci-primary-color)';
                loadingScreen.style.display = 'flex';
                loadingScreen.style.justifyContent = 'center';
                loadingScreen.style.alignItems = 'center';
                loadingScreen.style.zIndex = '9999';
                loadingScreen.id = 'loading-screen';

                let logo = document.createElement('img');
                logo.src = "<?php echo e(asset('/storage/' . $setting['software_logo_black'])); ?>"; 
                logo.style.width = '50%';
                logo.style.maxWidth = '300px';
                logo.alt = 'Daanrox';
                logo.classList.add('loadingLogo');

                loadingScreen.appendChild(logo);
                document.body.appendChild(loadingScreen);

                function removeLoadingScreen() {
                    loadingScreen.style.display = 'none';
                    document.getElementById('content').style.display = 'block';
                }

                setTimeout(function() {
                    removeLoadingScreen();
                }, 2200);
            });
        </script>

        <style>
            @keyframes pulseLogo {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }
            .loadingLogo {
                animation: pulseLogo infinite 2s;
            }
        </style>
    </body>
</html>
<?php /**PATH /home/sweet7/htdocs/sweet7.bet/resources/views/layouts/app.blade.php ENDPATH**/ ?>