<div class="modal fade" id="modalFrequenciaAulas" tabindex="-1" aria-labelledby="modalFrequenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg modern-modal">
            
            <div class="modal-header px-4 py-3 border-0 modal-header-gradient text-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-wrapper d-none d-sm-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 .064-1.041A4.97 4.97 0 0 0 2 13zm10-1c0-2.21-1.79-4-4-4a4.97 4.97 0 0 0-3 .92c-.212.148-.415.313-.608.494A5.001 5.001 0 0 0 1.22 12h13.56c-.361-.586-.885-1.066-1.503-1.387z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold m-0" id="modalFrequenciaLabel">Lançamento de Frequência Diária</h5>
                        <small class="text-white-50">Distribuição analítica da grade escolar por disciplinas</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 bg-light-premium">
                <!-- Card do Aluno -->
                <div class="card info-profile-card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center text-center text-md-start">
                            <div class="col-md-3 border-end-custom">
                                <small class="profile-label">👤 Aluno</small>
                                <span id="modalAlunoNome" class="profile-value d-block"><strong>---</strong></span>
                            </div>
                            <div class="col-md-3 border-end-custom">
                                <small class="profile-label">🎓 Turma</small>
                                <span id="modalTurma" class="profile-value d-block"><strong>---</strong></span>
                            </div>
                            <div class="col-md-3 border-end-custom">
                                <small class="profile-label">🔢 Matrícula</small>
                                <span id="modalMatricula" class="profile-value d-block"><strong>---</strong></span>
                            </div>
                            <div class="col-md-3">
                                <small class="profile-label">📅 Data da Frequência</small>
                                <span id="modalData" class="profile-value text-success-premium d-block fw-bold">---</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NOVO CARD: Registros do dia -->
                <div class="card info-profile-card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0d8a4f" class="bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v-1H1v-1h1v-1H1V9h1V8H1V7h1V6H1V5h1V4H1V3h1V2H1V1h1V0z"/>
                            </svg>
                            <small class="profile-label" style="font-size:0.8rem;">REGISTROS DO DIA</small>
                        </div>
                        <div id="registrosContainer" class="d-flex flex-wrap gap-2 mt-1">
                            <span class="text-muted fst-italic">Carregando...</span>
                        </div>
                    </div>
                </div>

                <!-- Botões de marcação em massa -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div id="badgeRegraContainer" class="d-flex align-items-center"></div>
                    <div class="d-flex gap-2 ctrl-container" id="controlesMassa">
                        <button type="button" class="btn btn-shortcut-p shadow-sm" onclick="executarMarcacaoMassa('presente')">✓ Todos Presentes</button>
                        <button type="button" class="btn btn-shortcut-a shadow-sm" onclick="executarMarcacaoMassa('falta')">✗ Todos Ausentes</button>
                    </div>
                </div>

                <div class="alert alert-warning text-center border-0 shadow-xs mb-3 py-2 text-dark font-sm rounded-3" id="msgModificacaoManual" style="display:none;">
                    ✍️ Você realizou alterações manuais. O destaque colorido indicará os itens modificados.
                </div>

                <div id="loadingAulas" class="text-center py-5">
                    <div class="spinner-border text-success-premium" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <p class="mt-3 text-muted fw-medium mb-0" style="font-size:0.9rem;">Consultando regras e ocorrências acadêmicas...</p>
                </div>

                <div id="gradeAulasEstrutura" style="display: none;">
                    <div class="period-container mb-4">
                        <h6 class="period-title d-flex align-items-center gap-2 text-success-premium mb-3">
                            <span class="indicator-bar bg-success-premium"></span> 🌅 Período da Manhã <span class="badge rounded-pill bg-white text-muted border ps-2 pe-2 fw-medium">Aulas 1 a 5</span>
                        </h6>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3" id="aulasManhaRow"></div>
                    </div>
                    
                    <div class="period-container">
                        <h6 class="period-title d-flex align-items-center gap-2 text-info-premium mb-3">
                            <span class="indicator-bar bg-info-premium"></span> 🌆 Período da Tarde <span class="badge rounded-pill bg-white text-muted border ps-2 pe-2 fw-medium">Aulas 6 a 9</span>
                        </h6>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3" id="aulasTardeRow"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light px-4 py-3 border-0 d-flex justify-content-between align-items-center">
                <span class="text-muted d-none d-md-inline" style="font-size:0.75rem;">* Cliques manuais sobrepõem as regras automatizadas.</span>
                <div class="d-flex gap-2 ctrl-container">
                    <button type="button" class="btn btn-modern-secondary px-4" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-modern-success px-4" id="salvarFrequenciaBtn" onclick="submeterFrequenciaAulas()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                            <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dados de backup (Nome e Período) caso o banco traga apenas as horas
const horariosDefault = {
    1: { inicio: "07:20", fim: "08:10", nome: "1ª Aula", periodo: "Manhã" },
    2: { inicio: "08:10", fim: "09:00", nome: "2ª Aula", periodo: "Manhã" },
    3: { inicio: "09:30", fim: "10:20", nome: "3ª Aula", periodo: "Manhã" },
    4: { inicio: "10:20", fim: "11:10", nome: "4ª Aula", periodo: "Manhã" },
    5: { inicio: "11:10", fim: "12:00", nome: "5ª Aula", periodo: "Manhã" },
    6: { inicio: "13:10", fim: "14:00", nome: "6ª Aula", periodo: "Tarde" },
    7: { inicio: "14:00", fim: "14:50", nome: "7ª Aula", periodo: "Tarde" },
    8: { inicio: "15:10", fim: "16:00", nome: "8ª Aula", periodo: "Tarde" },
    9: { inicio: "16:00", fim: "16:50", nome: "9ª Aula", periodo: "Tarde" }
};

// Variável que será abastecida pelo Banco de Dados
let horariosAulas = {};

let estadoFrequencias = {};
let matriculaAtual = '';
let dataAtual = '';

window.abrirModalFrequencia = async function(matricula, data, alunoNome, turma) {
    matriculaAtual = matricula;
    dataAtual = data;
    
    // Formatação manual da data (YYYY-MM-DD → dd/mm/aaaa)
    const partes = data.split('-');
    const dataFormatada = `${partes[2]}/${partes[1]}/${partes[0]}`;
    
    document.getElementById('modalAlunoNome').innerText = alunoNome || '';
    document.getElementById('modalTurma').innerText = turma || '';
    document.getElementById('modalMatricula').innerText = matricula || '';
    document.getElementById('modalData').innerText = dataFormatada;
    
    // Limpa e mostra loading nos registros
    const registrosDiv = document.getElementById('registrosContainer');
    registrosDiv.innerHTML = '<span class="text-muted fst-italic">Carregando registros...</span>';
    
    const divGrade = document.getElementById('gradeAulasEstrutura');
    const divLoading = document.getElementById('loadingAulas');
    
    if(divGrade) divGrade.style.display = 'none';
    if(divLoading) divLoading.style.display = 'block';
    
    const modalElement = document.getElementById('modalFrequenciaAulas');
    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
    modalInstance.show();

    try {
        const response = await fetch(`buscar_frequencia_aulas.php?matricula=${matricula}&data=${data}`);
        const resData = await response.json();
        
        // NOVO: Preenche a grade de horários com os dados vindos do banco de dados (se existirem)
        if (resData.horarios_aulas && Object.keys(resData.horarios_aulas).length > 0) {
            for (let i = 1; i <= 9; i++) {
                if(resData.horarios_aulas[i]) {
                    horariosAulas[i] = {
                        inicio: resData.horarios_aulas[i].inicio,
                        fim: resData.horarios_aulas[i].fim,
                        nome: horariosDefault[i].nome,       // mantem o texto visual
                        periodo: horariosDefault[i].periodo  // mantem a separação Manhã/Tarde
                    };
                }
            }
        } else {
            horariosAulas = horariosDefault; // Fallback se a query do banco falhar
        }

        // Exibe os registros do dia
        if (resData.registros && resData.registros.length > 0) {
            const badges = resData.registros.map(reg => {
                let cor = '';
                if (reg === 'Atestado') cor = 'bg-success-premium';
                else if (reg === 'Atraso') cor = 'bg-warning-premium text-dark';
                else if (reg === 'Dispensa') cor = 'bg-info-premium';
                else cor = 'bg-secondary';
                return `<span class="badge ${cor} px-3 py-2 rounded-pill shadow-sm">${reg}</span>`;
            }).join('');
            registrosDiv.innerHTML = badges;
        } else {
            registrosDiv.innerHTML = '<span class="text-muted fst-italic">Nenhum registro neste dia</span>';
        }
        
        // Chama o processamento das regras com os horários dinâmicos (não usa mais aula_atraso do banco)
        processarRegras(
            resData.situacao_diaria,
            resData.horario_atraso,
            resData.horario_dispensa,
            resData.is_atestado
        );
        
        // SOBRESCREVER com dados já salvos: Se já salvou no banco, recupera e joga na tela
        if (resData && resData.success && resData.frequencias && Object.keys(resData.frequencias).length > 0) {
            for (let aula in resData.frequencias) {
                estadoFrequencias[aula] = {
                    status: resData.frequencias[aula].status,
                    modificado: false
                };
            }
            gerarBadgeInformativo('banco', 'Registros salvos carregados do banco.');
        }
        
    } catch (err) {
        console.error("Erro ao processar regras:", err);
        registrosDiv.innerHTML = '<span class="text-danger">Erro ao carregar registros</span>';
    } finally {
        renderizarGradeAulas();
        if(divLoading) divLoading.style.display = 'none';
        if(divGrade) divGrade.style.display = 'block';
    }
};

function processarRegras(situacaoDiaria, horarioAtraso, horarioDispensa, isAtestado) {
    estadoFrequencias = {};
    let textoInformativo = '';
    let badgeTipo = 'sucesso';

    let situacaoLimpa = situacaoDiaria ? String(situacaoDiaria).trim().toUpperCase() : '';
    let temAtraso = !!horarioAtraso;
    let temDispensa = !!horarioDispensa;

    // Coloca todas como presentes inicialmente
    for (let i = 1; i <= 9; i++) {
        estadoFrequencias[i] = { status: 'presente', modificado: false };
    }

    // Regra Global de Ausência Total (Se não tem atraso nem dispensa, e a situação é Ausente)
    if (!temAtraso && !temDispensa && (situacaoLimpa === 'A')) {
        for (let i = 1; i <= 9; i++) estadoFrequencias[i].status = 'falta';
        textoInformativo = isAtestado 
            ? 'Atestado ativo: Todas as aulas marcadas como Falta (justificada).'
            : 'Aluno Ausente: Todas as 9 aulas marcadas como Falta.';
        gerarBadgeInformativo(isAtestado ? 'sucesso' : 'ausente', textoInformativo);
        return;
    }

    let aulaChegada = 0;
    let aulaSaida = 0;

    // --- REGRA DE NEGÓCIO: ATRASO ---
    if (horarioAtraso) {
        const hmAtraso = horarioAtraso.substring(0, 5); // Formato "HH:MM"
        
        for (let num in horariosAulas) {
            let aula = horariosAulas[num];
            // Se o horário do atraso for antes ou até o término desta aula
            if (hmAtraso <= aula.fim) {
                aulaChegada = parseInt(num);
                break;
            }
        }
        if (aulaChegada === 0) aulaChegada = 9; // Chegou depois de acabar tudo
        
        // Aplicação: Falta da 1ª até a aula da chegada. Presente no resto.
        for (let i = 1; i <= aulaChegada; i++) {
            estadoFrequencias[i].status = 'falta';
        }
        
        textoInformativo = `Atraso: Chegou durante a ${aulaChegada}ª aula. Aulas 1 a ${aulaChegada} = Falta.`;
        badgeTipo = 'alerta';
    }

    // --- REGRA DE NEGÓCIO: DISPENSA ---
    if (horarioDispensa) {
        const hmDispensa = horarioDispensa.substring(0, 5);
        let exatoInicio = false;

        for (let num in horariosAulas) {
            let aula = horariosAulas[num];
            if (hmDispensa === aula.inicio) {
                aulaSaida = parseInt(num);
                exatoInicio = true; // Saiu EXATAMENTE no início da aula
                break;
            } else if (hmDispensa > aula.inicio && hmDispensa <= aula.fim) {
                aulaSaida = parseInt(num);
                exatoInicio = false; // Assistiu pelo menos parte
                break;
            }
        }
        
        // Se saiu depois que a última aula acabou
        if (aulaSaida === 0) {
            for (let num in horariosAulas) {
                if (hmDispensa > horariosAulas[num].fim) aulaSaida = parseInt(num) + 1;
            }
        }

        if (aulaSaida > 0 && aulaSaida <= 9) {
            // Aplicação da Aula da Dispensa:
            // Se saiu no início = Falta. Se assistiu uma parte e NÃO faltou por atraso = Presente
            if (exatoInicio) {
                estadoFrequencias[aulaSaida].status = 'falta';
            } else {
                if (aulaChegada !== aulaSaida) { 
                    estadoFrequencias[aulaSaida].status = 'presente'; 
                }
            }

            // Aplicação das aulas PÓS-Dispensa: Todas Falta
            for (let i = aulaSaida + 1; i <= 9; i++) {
                if(estadoFrequencias[i]) estadoFrequencias[i].status = 'falta';
            }
            
            if (temAtraso) {
                textoInformativo = `Atraso (chegou na ${aulaChegada}ª) e Dispensa (saiu na ${aulaSaida}ª). Faltas aplicadas corretamente.`;
            } else {
                textoInformativo = `Dispensa: Saída na ${aulaSaida}ª aula. Aula ${aulaSaida} considerada ${exatoInicio ? 'Ausente' : 'Presente'} e seguintes = Falta.`;
            }
            badgeTipo = 'alerta';
        }
    }

    // Se estiver tudo normal
    if (!temAtraso && !temDispensa && situacaoLimpa !== 'A') {
        textoInformativo = 'Presença normal: Todas as aulas como Presente.';
        badgeTipo = 'sucesso';
    }

    gerarBadgeInformativo(badgeTipo, textoInformativo);
}

function renderizarGradeAulas() {
    const manhaContainer = document.getElementById('aulasManhaRow');
    const tardeContainer = document.getElementById('aulasTardeRow');
    if (!manhaContainer || !tardeContainer) return;
    manhaContainer.innerHTML = '';
    tardeContainer.innerHTML = '';
    for (let i = 1; i <= 5; i++) { manhaContainer.appendChild(criarCardAula(i)); }
    for (let i = 6; i <= 9; i++) { tardeContainer.appendChild(criarCardAula(i)); }
}

function criarCardAula(aulaNumero) {
    const aula = horariosAulas[aulaNumero];
    const infoAula = estadoFrequencias[aulaNumero] || { status: 'falta', modificado: false };
    const status = infoAula.status;
    const classeBorda = (status === 'presente') ? 'status-borda-presente' : 'status-borda-falta';
    
    const col = document.createElement('div');
    col.className = 'col';
    col.innerHTML = `
        <div class="card card-aula h-100 border-0 shadow-sm ${classeBorda} ${infoAula.modificado ? 'card-item-modificado' : ''}">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="text-center mb-2">
                    <span class="aula-label-titulo">${aula.nome}</span>
                    <span class="aula-label-horario d-block">${aula.inicio} às ${aula.fim}</span>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-action-presenca ${status === 'presente' ? 'active' : ''}" onclick="alterarStatus(${aulaNumero}, 'presente')">✓ Presente</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-action-falta ${status === 'falta' ? 'active' : ''}" onclick="alterarStatus(${aulaNumero}, 'falta')">✗ Ausente</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    return col;
}

function alterarStatus(aulaNumero, novoStatus) {
    estadoFrequencias[aulaNumero] = { status: novoStatus, modificado: true };
    document.getElementById('msgModificacaoManual').style.display = 'block';
    renderizarGradeAulas();
    gerarBadgeInformativo('manual', 'Modificação manual aplicada. Lembre de Salvar.');
}

function executarMarcacaoMassa(statusAlvo) {
    for (let i = 1; i <= 9; i++) {
        estadoFrequencias[i] = { status: statusAlvo, modificado: true };
    }
    document.getElementById('msgModificacaoManual').style.display = 'block';
    renderizarGradeAulas();
    const texto = statusAlvo === 'presente' ? 'TODOS PRESENTES' : 'TODOS AUSENTES';
    gerarBadgeInformativo('manual', `Marcação em massa: ${texto}`);
}

function gerarBadgeInformativo(tipo, msg) {
    const container = document.getElementById('badgeRegraContainer');
    if (!container) return;
    let bgStyle = 'bg-secondary';
    let icon = 'ℹ️';
    if (tipo === 'sucesso') { bgStyle = 'bg-success-premium text-white'; icon = '✅'; }
    else if (tipo === 'ausente') { bgStyle = 'bg-danger-premium text-white'; icon = '🚨'; }
    else if (tipo === 'alerta') { bgStyle = 'bg-warning-premium text-dark'; icon = '⚡'; }
    else if (tipo === 'manual') { bgStyle = 'bg-primary text-white'; icon = '✍️'; }
    else if (tipo === 'banco') { bgStyle = 'bg-dark text-white'; icon = '🗄️'; }
    container.innerHTML = `
        <span class="badge ${bgStyle} px-3 py-2 d-flex align-items-center gap-2 info-badge-animated shadow-xs">
            <span style="font-size:1.05rem;">${icon}</span> ${msg}
        </span>
    `;
}

async function submeterFrequenciaAulas() {
    const btn = document.getElementById('salvarFrequenciaBtn');
    const originalContent = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Processando...`;

    const frequenciasFormatadas = {};
    for(let aula in estadoFrequencias) {
        frequenciasFormatadas[aula] = { status: estadoFrequencias[aula].status };
    }
    const payload = { matricula: matriculaAtual, data: dataAtual, frequencias: frequenciasFormatadas };
    
    try {
        const response = await fetch('salvar_frequencia_aulas.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const r = await response.json();
        if (r.success) {
            gerarBadgeInformativo('sucesso', 'Frequência salva com sucesso!');
            setTimeout(() => {
                const modalEl = document.getElementById('modalFrequenciaAulas');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if(modalInstance) modalInstance.hide();
                location.reload(); 
            }, 1000);
        } else {
            alert('Erro ao salvar os dados.');
            btn.disabled = false;
            btn.innerHTML = originalContent;
        }
    } catch {
        alert('Erro de conexão.');
        btn.disabled = false;
        btn.innerHTML = originalContent;
    }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

.modern-modal {
    font-family: 'Poppins', sans-serif;
    border-radius: 20px !important;
    overflow: hidden;
}
.bg-light-premium { background-color: #f4f6f8; }
.modal-header-gradient { background: linear-gradient(135deg, #0d8a4f, #15b067) !important; }
.header-icon-wrapper { background-color: rgba(255, 255, 255, 0.2); padding: 8px; border-radius: 12px; }
.info-profile-card { background-color: #ffffff !important; border-radius: 14px !important; }
.profile-label { font-size: 0.7rem; font-weight: 600; color: #8a94a6; text-transform: uppercase; }
.profile-value { font-size: 0.95rem; font-weight: 700; color: #1e293b; }

@media (min-width: 768px) {
    .border-end-custom { border-right: 1px solid #e2e8f0 !important; }
}

.info-badge-animated { font-size: 0.8rem; font-weight: 600; border-radius: 8px; line-height: 1.4; animation: fadeIn 0.3s ease; }
.text-success-premium { color: #0d8a4f !important; }
.text-info-premium { color: #0284c7 !important; }
.bg-success-premium { background-color: #0d8a4f !important; }
.bg-info-premium { background-color: #0284c7 !important; }
.bg-warning-premium { background-color: #facc15 !important; }
.bg-danger-premium { background-color: #ef4444 !important; }

.btn-shortcut-p { background-color: #e6f4ea; color: #0d8a4f; font-size: 0.78rem; font-weight: 600; border: none; border-radius: 8px; padding: 6px 14px; transition: 0.2s; }
.btn-shortcut-p:hover { background-color: #0d8a4f; color: white; }
.btn-shortcut-a { background-color: #fce8e6; color: #c5221f; font-size: 0.78rem; font-weight: 600; border: none; border-radius: 8px; padding: 6px 14px; transition: 0.2s; }
.btn-shortcut-a:hover { background-color: #c5221f; color: white; }

.indicator-bar { display: inline-block; width: 5px; height: 16px; border-radius: 2px; vertical-align: middle; }
.period-title { font-weight: 700; font-size: 0.92rem; }
.card-aula { border-radius: 12px !important; background: #ffffff; transition: transform 0.2s, box-shadow 0.2s; }
.card-aula:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0,0,0,0.05) !important; }

.status-borda-presente { border-left: 5px solid #0d8a4f !important; }
.status-borda-falta { border-left: 5px solid #ef4444 !important; }
.card-item-modificado { box-shadow: 0 0 0 2px #3b82f6 !important; }

.aula-label-titulo { font-size: 0.85rem; font-weight: 700; color: #1e293b; }
.aula-label-horario { font-size: 0.72rem; color: #64748b; font-weight: 500; }

.btn-action-presenca, .btn-action-falta {
    width: 100%; font-size: 0.75rem !important; font-weight: 600 !important; padding: 6px 0 !important;
    border-radius: 8px !important; border: none; transition: all 0.2s ease;
}
.btn-action-presenca { background-color: #e6f4ea; color: #0d8a4f; }
.btn-action-presenca.active, .btn-action-presenca:hover { background-color: #0d8a4f; color: white; }
.btn-action-falta { background-color: #fce8e6; color: #c5221f; }
.btn-action-falta.active, .btn-action-falta:hover { background-color: #c5221f; color: white; }

.btn-modern-secondary { background-color: #e2e8f0; color: #475569; font-weight: 600; font-size: 0.88rem; border-radius: 8px; border: none; padding: 8px 20px; transition: background 0.2s; }
.btn-modern-secondary:hover { background-color: #cbd5e1; }
.btn-modern-success { background-color: #0d8a4f; color: white; font-weight: 600; font-size: 0.88rem; border-radius: 8px; border: none; padding: 8px 20px; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s; }
.btn-modern-success:hover { background-color: #0a6d3e; }

@keyframes fadeIn { from { opacity: 0; transform: scale(0.98); } to { opacity: 1; transform: scale(1); } }
@keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 576px) {
    .ctrl-container { width: 100% !important; flex-direction: column; gap: 6px; }
    .ctrl-container button { width: 100% !important; text-align: center; }
}
</style>