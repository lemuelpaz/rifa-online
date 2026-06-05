<div id="card-caixa" class="cardtotalabre card-caixa-abrir<?= $i ?> mb-1">
    <audio id="caixa-audio-abrindo<?= $i ?>" src="/caixa-abrindo.mp3" preload="auto"></audio>
    <audio id="caixa-audio-ganhou<?= $i ?>" src="/roleta-ganhou.wav" preload="auto"></audio>
    <audio id="caixa-audio-perdeu<?= $i ?>" src="/roleta-perdeu.wav" preload="auto"></audio>
    <div class="card-body mb-1 pb-1">
        <div class="caixa-premiada--giros">
            <div class="lista font-xs">
                <div>
                    <div class="caixaPremiada_video__3oQjY" style="pointer-events: none; opacity: 0;">
                    </div>
                    <div class="caixa-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer bg-gradient-yellow font-weight-600 justify-content-between">
                        <span><i class="bi bi-gift-fill"></i> Caixa misteriosa</span>
                        <span class="badge text-bg-light bg-opacity-75 text-uppercase btn-abrircaixa<?= $i ?>">Abrir!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="card-caixa" class="card-caixa-perdeu<?= $i ?> d-none mb-1 ">
    <div class="card-body mb-1 pb-1">
        <div class="caixa-premiada--giros bg-gradient-pink">
            <div class="lista font-xs">
                <div class="caixa-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer bg-gradient-pink font-weight-600 justify-content-between">
                    <span><i class="bi bi-gift-fill"></i> Caixa misteriosa</span>
                    <span class="badge text-bg-light bg-opacity-75 text-uppercase">Aberta</span>
                </div>
                <div class="mb-2">
                    <div class="row justify-content-center align-items-center py-2 text-white">
                        <div class="col-auto ps-0">
                            <h1><i class="bi bi-box"></i></h1>
                        </div>
                        <div class="col-auto">
                            <p class="m-0 p-0">Não foi dessa vez</p>
                            <p class="font-xxs m-0 p-0">sua caixa misteriosa veio vazia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-1 card-caixa-ganhou<?= $i ?> d-none">
    <div class="card-body mb-1 pb-1">
        <div class="roleta-premiada--giros bg-gradient-green">
            <div class="lista font-xs">
                <div class="roleta-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer bg-gradient-green font-weight-600 justify-content-between">
                    <span><i class="bi bi-play-circle-fill"></i> Caixa misteriosa</span>
                    <span class="badge text-bg-light bg-opacity-75 text-uppercase">Aberta</span>
                </div>
                <div class="mb-2">
                    <div class="row justify-content-center align-items-center py-2 text-white">
                        <div class="col-auto pe-0">
                            <h1><i class="bi bi-emoji-laughing"></i></h1>
                        </div>
                        <div class="col-auto fw-bolder">
                            <p class="m-0 p-0">Parabéns</p>
                            <p class="m-0 p-0 font-xxs">sua caixinha contem um prêmio</p>
                            <p class="m-0 p-0 font-xxs">você ganhou <?= $valorGanhadorb[$i] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="area-box<?= $i ?>"></div>