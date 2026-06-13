<?php
session_start();
include('conexao.php');
include('verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - FrequenCy</title>

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
        .hero-about {
            background: linear-gradient(135deg, #0d8a4f 0%, #08563a 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 50px;
            box-shadow: 0 8px 25px rgba(13, 138, 79, 0.2);
        }

        .hero-about h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-about p {
            font-size: 1.2rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
        }

        /* About Section */
        .about-section {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .about-section h2 {
            color: #0d8a4f;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .about-section h3 {
            color: #1c3249;
            font-weight: 600;
            font-size: 1.4rem;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .about-section p {
            color: #1c3249;
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .feature-card {
            background: linear-gradient(135deg, #f0f9f4 0%, #ffffff 100%);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            border-left: 4px solid #0d8a4f;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(13, 138, 79, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .feature-card h4 {
            color: #0d8a4f;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #1c3249;
            margin: 0;
            font-size: 0.95rem;
        }

        /* CTA Button */
        .btn-cta {
            background-color: #0d8a4f;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-top: 30px;
        }

        .btn-cta:hover {
            background-color: #086333;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(13, 138, 79, 0.3);
            color: white;
        }

        .btn-cta-secondary {
            background-color: #ff7a1a;
        }

        .btn-cta-secondary:hover {
            background-color: #e86900;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-item {
            margin-bottom: 40px;
            position: relative;
            padding-left: 40px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            background-color: #0d8a4f;
            border-radius: 50%;
            border: 4px solid #f0f9f4;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: 9px;
            top: 20px;
            width: 2px;
            height: 20px;
            background-color: #0d8a4f;
        }

        .timeline-item:last-child::after {
            display: none;
        }

        .timeline-item h4 {
            color: #0d8a4f;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .timeline-item p {
            color: #1c3249;
            margin: 0;
        }

        /* Team Button */
        .btn-team {
            background-color: #ff7a1a;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-team:hover {
            background-color: #e86900;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 122, 26, 0.3);
            color: white;
        }

        @media (max-width: 768px) {
            .hero-about h1 {
                font-size: 1.8rem;
            }

            .about-section {
                padding: 25px;
            }

            .about-section h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="page-container">

    <!-- se a conta for coletor, inclui a navbar do coletor, mas se for admin, inclui a navbar do admin -->
    <?php
    if (isset($_SESSION['email']) && str_ends_with($_SESSION['email'], '@coletor.com')) {
        include('navbar_coletor.php');
    } else {
        include('navbar.php');
    }
    ?>

        <div class="main-content">
            <div class="container">
                <!-- Hero Section -->
                <div class="hero-about">
                    <h1>Sobre o FrequenCy</h1>
                    <p>Sistema inteligente e intuitivo para gerenciamento de frequência escolar e de alunos</p>
                </div>

                <!-- Missão, Visão e Valores -->
                <div class="about-section mb-5">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                        </svg>
                        Nossa Missão
                    </h2>
                    <p>
                        O FrequenCy foi desenvolvido com o objetivo de simplificar e otimizar o gerenciamento de frequência em instituições educacionais.
                        Entendemos que controlar a presença de alunos é fundamental para o sucesso acadêmico, e por isso criamos uma solução que
                        torna esse processo rápido, eficiente e confiável.
                    </p>

                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                        Nossa Visão
                    </h2>
                    <p>
                        Ser a plataforma de referência para gerenciamento de frequência escolar, oferecendo tecnologia moderna que facilita
                        a vida de educadores e gestores educacionais em toda a região.
                    </p>

                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5" />
                        </svg>
                        Nossos Valores
                    </h2>
                    <ul style="color: #1c3249; font-size: 1rem; line-height: 1.8;">
                        <li><strong>Inovação:</strong> Sempre buscamos aprimorar nossas funcionalidades com as melhores práticas do mercado</li>
                        <li><strong>Confiabilidade:</strong> Seus dados são seguros e você pode contar com nosso sistema sempre</li>
                        <li><strong>Eficiência:</strong> Automatizamos processos para economizar seu tempo precioso</li>
                        <li><strong>Acessibilidade:</strong> Uma interface amigável que qualquer pessoa possa usar facilmente</li>
                        <li><strong>Suporte:</strong> Estamos sempre aqui para ajudar no que precisar</li>
                    </ul>
                </div>

                <!-- Funcionalidades Principais -->
                <div class="about-section">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                        </svg>
                        Principais Funcionalidades
                    </h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />
                                </svg>
                            </div>
                            <h4>Registro de Frequência</h4>
                            <p>Registre a frequência dos alunos de forma rápida e intuitiva</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                </svg>
                            </div>
                            <h4>Gerenciamento de Alunos</h4>
                            <p>Cadastre e administre todos os dados dos seus alunos</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                                    <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z" />
                                </svg>
                            </div>
                            <h4>Relatórios Detalhados</h4>
                            <p>Gere relatórios com gráficos e estatísticas de frequência</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-phone-flip" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11 1H5a1 1 0 0 0-1 1v6a.5.5 0 0 1-1 0V2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a.5.5 0 0 1-1 0V2a1 1 0 0 0-1-1m1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-2a.5.5 0 0 0-1 0v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a.5.5 0 0 0-1 0zM1.713 7.954a.5.5 0 1 0-.419-.908c-.347.16-.654.348-.882.57C.184 7.842 0 8.139 0 8.5c0 .546.408.94.823 1.201.44.278 1.043.51 1.745.696C3.978 10.773 5.898 11 8 11q.148 0 .294-.002l-1.148 1.148a.5.5 0 0 0 .708.708l2-2a.5.5 0 0 0 0-.708l-2-2a.5.5 0 1 0-.708.708l1.145 1.144L8 10c-2.04 0-3.87-.221-5.174-.569-.656-.175-1.151-.374-1.47-.575C1.012 8.639 1 8.506 1 8.5c0-.003 0-.059.112-.17.115-.112.31-.242.6-.376Zm12.993-.908a.5.5 0 0 0-.419.908c.292.134.486.264.6.377.113.11.113.166.113.169s0 .065-.13.187c-.132.122-.352.26-.677.4-.645.28-1.596.523-2.763.687a.5.5 0 0 0 .14.99c1.212-.17 2.26-.43 3.02-.758.38-.164.713-.357.96-.587.246-.229.45-.537.45-.919 0-.362-.184-.66-.412-.883s-.535-.411-.882-.571M7.5 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                </svg>
                            </div>
                            <h4>Responsivo</h4>
                            <p>Acesse de qualquer dispositivo, em qualquer lugar</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                </svg>
                            </div>
                            <h4>Seguro</h4>
                            <p>Seus dados protegidos com os melhores padrões de segurança</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-sliders" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z" />
                                </svg>
                            </div>
                            <h4>Fácil Configuração</h4>
                            <p>Configure seu sistema em poucos minutos</p>
                        </div>
                    </div>
                </div>

                <!-- Histórico -->
                <div class="about-section">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#0d8a4f" class="bi bi-geo-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411" />
                        </svg>
                        Nossa Jornada
                    </h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <h4>02/2026</h4>
                            <p>Identificamos a necessidade de uma solução moderna para gerenciamento de frequência escolar.</p>
                        </div>
                        <div class="timeline-item">
                            <h4>03/2026 - 06/2026</h4>
                            <p>Desenvolvemos a primeira versão do FrequenCy com foco em usabilidade e eficiência.</p>
                        </div>
                        <div class="timeline-item">
                            <h4>06/2026</h4>
                            <p>Lançamos o FrequenCy para transformar a forma como a escola gerencia frequência.</p>
                        </div>
                        <div class="timeline-item">
                            <h4>07/2026</h4>
                            <p>Continuamos aprimorando o sistema com novos recursos baseado no feedback dos usuários.</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Para Equipe -->
                <div class="about-section" style="background: linear-gradient(135deg, #f0f9f4 0%, #ffffff 100%); text-align: center;">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#0d8a4f" class="bi bi-person-workspace mb-3" viewBox="0 0 16 16">
                            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
                        </svg> <br>
                        Conheça Nosso Time
                    </h2>
                    <p>Somos uma equipe dedicada e apaixonada por educação e tecnologia. Clique abaixo para conhecer melhor os profissionais que tornaram o FrequenCy possível.</p>
                    <a href="equipe.php" class="btn-team">Conhecer a Equipe</a>
                </div>

                <!-- Contato -->
                <div class="about-section">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#0d8a4f" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                        </svg>
                        Entre em Contato
                    </h2>
                    <p>Tem dúvidas ou sugestões? Adoramos ouvir de você!</p>
                    <div class="row mt-4" style="margin-bottom: 0;">
                        <div class="col-md-6">
                            <h4 style="color: #0d8a4f; margin-top: 0;">Email:</h4>
                            <p><a href="mailto:guilherme.oliveira200@aluno.ce.gov.br" style="color: #0d8a4f; text-decoration: none;">guilherme.oliveira200@aluno.ce.gov.br</a></p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color: #0d8a4f; margin-top: 0;">Suporte:</h4>
                            <p><a href="tel:(85)98160-1101" style="color: #0d8a4f; text-decoration: none;">(85)98160-1101</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('footer.php'); ?>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>