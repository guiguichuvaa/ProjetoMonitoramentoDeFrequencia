<?php
session_start();
include('conexao.php');
include('verifica_login.php');

// Array com dados da equipe - personalize com os dados reais da sua equipe
$equipe = [
    [
        'nome' => 'Guilherme Gomes',
        'cargo' => 'Desenvolvedor Backend, Designer e Co-Líder de Projeto',
        'descricao' => 'O cérebro por trás do código. Guilherme é o responsável por toda a lógica e estrutura do FrequenCy. Ele é o mestre das tecnologias utilizadas e garante que tudo funcione de forma fluida e eficiente.',
        'email' => 'guilhermeggoliver@gmail.com',
        'imagem' => 'img/team/gui.jpeg',
        'skills' => ['Liderança', 'Visão Estratégica', 'Educação']
    ],
    [
        'nome' => 'Janinny Vierira',
        'cargo' => 'Project Owner e Co-líder de Projeto',
        'descricao' => 'A mente criativa por trás do FrequenCy. Janinny teve a visão de criar uma solução inovadora para o controle de frequência e liderou a equipe para transformar essa visão em realidade.',
        'email' => 'janinny.menezes@aluno.ce.gov.br',
        'imagem' => '',
        'skills' => ['Planejamento', 'Visão de Negócio', 'Comunicação']
    ],
    [
        'nome' => 'Othon Mourão',
        'cargo' => 'Desenvolvedor Full Stack',
        'descricao' => 'O braço direito de Guilherme, Othon é o responsável por transformar as ideias em código. Ele é o mestre das tecnologias utilizadas no FrequenCy e garante que tudo funcione de forma fluida e eficiente.',
        'email' => 'othon@frequency.com',
        'imagem' => '',
        'skills' => ['Backend', 'Banco de Dados', 'Performance']
    ],
    [
        'nome' => 'Letícia Martins',
        'cargo' => 'Quality Assurance (QA) e Documentação',
        'descricao' => 'Criativa e detalhista, Letícia garante a qualidade do FrequenCy. Ela desenvolve e mantém a documentação técnica do sistema.',
        'email' => 'leticia@frequency.com',
        'imagem' => '',
        'skills' => ['QA', 'Documentação', 'Testes']
    ],
    [
        'nome' => 'Murilo Rodrigues',
        'cargo' => 'Desenvolvedor Frontend',
        'descricao' => 'Garantidor da qualidade do FrequenCy. Murilo testa cada funcionalidade para garantir que você tem a melhor experiência possível.',
        'email' => 'murilo@frequency.com',
        'imagem' => '',
        'skills' => ['Frontend', 'UI/UX', 'Testes']
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe - FrequenCy</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon" width="22" height="22">

    <style>
        body {
            background-color: #f0f9f4;
            font-family: 'Poppins', sans-serif;
            display: block;
            margin: 0;
        }

        .page-container {
            margin-top: 3vh;
            width: 95%;
            max-width: 1600px;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 50px;
        }

        .main-content {
            flex: 1;
            padding: 40px 20px;
        }

        /* Hero Section */
        .hero-team {
            background: linear-gradient(135deg, #0d8a4f 0%, #08563a 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 50px;
            box-shadow: 0 8px 25px rgba(13, 138, 79, 0.2);
        }

        .hero-team h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-team p {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Carousel Section */
        .carousel-section {
            background-color: white;
            border-radius: 20px;
            padding: 40px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            margin-bottom: 50px;
        }

        /* Custom Carousel */
        .carousel-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }

        .carousel-inner-custom {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .carousel-item-custom {
            display: none;
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
            padding: 40px 20px;
        }

        .carousel-item-custom.active {
            display: flex;
            opacity: 1;
            gap: 40px;
            align-items: center;
        }

        .carousel-item-custom.active.fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .member-image {
            flex: 0 0 300px;
            text-align: center;
        }

        .member-image img {
            width: 250px;
            height: 250px;
            border-radius: 15px;
            object-fit: cover;
            border: 5px solid #0d8a4f;
            box-shadow: 0 8px 25px rgba(13, 138, 79, 0.15);
        }

        .member-info {
            flex: 1;
            min-width: 0;
        }

        .member-info h2 {
            color: #0d8a4f;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .member-info .cargo {
            color: #ff7a1a;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .member-info p {
            color: #1c3249;
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .member-skills {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .skill-badge {
            background-color: #f0f9f4;
            color: #0d8a4f;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            border: 1px solid #0d8a4f;
        }

        .member-email {
            display: inline-block;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            background-color: #0d8a4f;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .member-email:hover {
            background-color: #086333;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(13, 138, 79, 0.3);
            color: white;
        }

        /* Carousel Controls */
        .carousel-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
        }

        .carousel-btn {
            width: 50px;
            height: 50px;
            border: none;
            background-color: #0d8a4f;
            color: white;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-btn:hover {
            background-color: #086333;
            transform: scale(1.1);
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .indicator.active {
            background-color: #0d8a4f;
            width: 16px;
            height: 16px;
        }

        .indicator:hover {
            background-color: #0d8a4f;
        }

        /* Grid de Equipe Alternativa */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .team-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(13, 138, 79, 0.15);
        }

        .team-card-image {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #0d8a4f 0%, #08563a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }

        .team-card-body {
            padding: 25px;
        }

        .team-card h3 {
            color: #0d8a4f;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .team-card .cargo {
            color: #ff7a1a;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .team-card p {
            color: #1c3249;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .team-card .skill-badge {
            font-size: 0.8rem;
            padding: 6px 12px;
        }

        .toggle-view {
            text-align: center;
            margin-bottom: 30px;
        }

        .toggle-btn {
            background-color: #ff7a1a;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background-color: #e86900;
            transform: translateY(-3px);
        }

        .toggle-btn.active {
            background-color: #0d8a4f;
        }

        .carousel-section.hidden,
        .team-grid-section.hidden {
            display: none;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .hero-team h1 {
                font-size: 1.8rem;
            }

            .carousel-item-custom.active {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .member-image {
                flex: 0 0 auto;
            }

            .member-image img {
                width: 200px;
                height: 200px;
            }

            .member-info h2 {
                font-size: 1.5rem;
            }

            .carousel-section {
                padding: 20px 10px;
            }

            .carousel-btn {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['email']) && str_ends_with($_SESSION['email'], '@coletor.com')) {
        include('navbar_coletor.php');
    } else {
        include('navbar.php');
    }
    ?>
    <div class="page-container">
        

        <div class="main-content">
            <div class="container">
                <!-- Hero Section -->
                <div class="hero-team">
                    <h1>Nossa Equipe</h1>
                    <p>Conheça os profissionais dedicados que tornaram o FrequenCy possível</p>
                </div>

                <!-- Toggle View Buttons -->
                <div class="toggle-view">
                    <button class="toggle-btn active" onclick="toggleView('carousel')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0" />
                        </svg>
                        Carrossel

                    </button>
                    <button class="toggle-btn" onclick="toggleView('grid')" style="margin-left: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                            <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1z" />
                        </svg>
                        Grade
                    </button>
                </div>

                <!-- Carousel Section -->
                <div class="carousel-section" id="carousel-section">
                    <div class="carousel-container">
                        <div class="carousel-inner-custom">
                            <?php foreach ($equipe as $index => $membro): ?>
                                <?php $foto = !empty($membro['imagem']) ? $membro['imagem'] : 'https://ui-avatars.com/api/?name=' . urlencode($membro['nome']) . '&background=0d8a4f&color=fff&size=250&bold=true'; ?>
                                <div class="carousel-item-custom <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                                    <div class="member-image">
                                        <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($membro['nome']); ?>">
                                    </div>
                                    <div class="member-info">
                                        <h2><?php echo htmlspecialchars($membro['nome']); ?></h2>
                                        <div class="cargo"><?php echo htmlspecialchars($membro['cargo']); ?></div>
                                        <p><?php echo htmlspecialchars($membro['descricao']); ?></p>
                                        <div class="member-skills align-items-center">
                                            <?php foreach ($membro['skills'] as $skill): ?>
                                                <span class="skill-badge"><?php echo htmlspecialchars($skill); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <a href="mailto:<?php echo htmlspecialchars($membro['email']); ?>" class="member-email">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                                            </svg>

                                            <?php echo htmlspecialchars($membro['email']); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Carousel Controls -->
                    <div class="carousel-controls">
                        <button class="carousel-btn" onclick="previousMember()">❮</button>
                        <div class="carousel-indicators">
                            <?php foreach ($equipe as $index => $membro): ?>
                                <div class="indicator <?php echo $index === 0 ? 'active' : ''; ?>" onclick="goToMember(<?php echo $index; ?>)"></div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-btn" onclick="nextMember()">❯</button>
                    </div>
                </div>

                <!-- Team Grid Section -->
                <div class="team-grid-section hidden" id="grid-section">
                    <div class="team-grid">
                        <?php foreach ($equipe as $membro): ?>
                            <?php $foto = empty($membro['imagem']) ? 'https://ui-avatars.com/api/?name=' . urlencode($membro['nome']) . '&background=0d8a4f&color=fff&size=250&bold=true' : $membro['imagem']; ?>
                            <div class="team-card">
                                <div class="team-card-image">
                                    <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($membro['nome']); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0;">
                                </div>
                                <div class="team-card-body">
                                    <h3><?php echo htmlspecialchars($membro['nome']); ?></h3>
                                    <div class="cargo"><?php echo htmlspecialchars($membro['cargo']); ?></div>
                                    <p><?php echo htmlspecialchars($membro['descricao']); ?></p>
                                    <div class="member-skills" style="justify-content: center;">
                                        <?php foreach ($membro['skills'] as $skill): ?>
                                            <span class="skill-badge"><?php echo htmlspecialchars($skill); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <a href="mailto:<?php echo htmlspecialchars($membro['email']); ?>" class="member-email" style="margin-top: 15px;">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                                        </svg>
                                        <?php echo htmlspecialchars($membro['email']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include('footer.php'); ?>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        let currentMemberIndex = 0;
        const totalMembers = <?php echo count($equipe); ?>;

        function showMember(index) {
            // Remove active da posição anterior
            document.querySelectorAll('.carousel-item-custom').forEach(item => {
                item.classList.remove('active', 'fade-in');
            });
            document.querySelectorAll('.indicator').forEach(dot => {
                dot.classList.remove('active');
            });

            // Define o índice correto
            currentMemberIndex = (index + totalMembers) % totalMembers;

            // Adiciona active na nova posição
            document.querySelector(`[data-index="${currentMemberIndex}"]`).classList.add('active', 'fade-in');
            document.querySelectorAll('.indicator')[currentMemberIndex].classList.add('active');
        }

        function nextMember() {
            showMember(currentMemberIndex + 1);
        }

        function previousMember() {
            showMember(currentMemberIndex - 1);
        }

        function goToMember(index) {
            showMember(index);
        }

        function toggleView(view) {
            const carouselSection = document.getElementById('carousel-section');
            const gridSection = document.getElementById('grid-section');
            const carouselBtn = document.querySelectorAll('.toggle-btn')[0];
            const gridBtn = document.querySelectorAll('.toggle-btn')[1];

            if (view === 'carousel') {
                carouselSection.classList.remove('hidden');
                gridSection.classList.add('hidden');
                carouselBtn.classList.add('active');
                gridBtn.classList.remove('active');
            } else {
                carouselSection.classList.add('hidden');
                gridSection.classList.remove('hidden');
                carouselBtn.classList.remove('active');
                gridBtn.classList.add('active');
            }
        }

        // Auto-play carousel (opcional - descomente para ativar)
        // setInterval(nextMember, 5000);
    </script>
</body>

</html>