<div class="mb-2 cardtotalgirar card-girar<?= $i ?>">
    <div class="card-body mb-1 pb-1">
        <div class="roleta-premiada--giros">
            <div class="lista font-xs">
                <div class="roleta-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer bg-gradient-cyan font-weight-600 justify-content-between">
                    <span><i class="bi bi-play-circle-fill"></i> Giro de Roleta</span>
                    <span class="badge text-bg-light bg-opacity-75 text-uppercase btn-abrir-modal<?= $i ?>">Girar!</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-1 card-perdeu<?= $i ?> d-none">
    <div class="card-body mb-1 pb-1">
        <div class="roleta-premiada--giros bg-gradient-pink">
            <div class="lista font-xs">
                <div class="roleta-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer bg-gradient-pink font-weight-600 justify-content-between">
                    <span><i class="bi bi-play-circle-fill"></i> Giro de Roleta</span>
                    <span class="badge text-bg-light bg-opacity-75 text-uppercase">Aberta</span>
                </div>
                <div class="mb-1">
                    <div class="row justify-content-center align-items-center py-2 text-white">
                        <div class="col-auto pe-0">
                            <h1><i class="bi bi-emoji-frown"></i></h1>
                        </div>
                        <div class="col-auto">
                            <p class="m-0 p-0">Não foi dessa vez</p>
                            <p class="font-xxs m-0 p-0">sua <b>roleta não premiou</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-1 card-ganhou<?= $i ?> d-none">
    <div class="card-body mb-1 pb-1">
        <div class="roleta-premiada--giros bg-gradient-green">
            <div class="lista font-xs">
                <div class="roleta-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer bg-gradient-green font-weight-600 justify-content-between">
                    <span><i class="bi bi-play-circle-fill"></i> Giro de Roleta</span>
                    <span class="badge text-bg-light bg-opacity-75 text-uppercase">Aberta</span>
                </div>
                <div class="mb-1">
                    <div class="row justify-content-center align-items-center py-2 text-white">
                        <div class="col-auto pe-0">
                            <h1><i class="bi bi-emoji-laughing"></i></h1>
                        </div>
                        <div class="col-auto fw-bolder">
                            <p class="m-0 p-0">Parabéns</p>
                            <p class="m-0 p-0 font-xxs">sua roleta contem um prêmio</p>
                            <p class="m-0 p-0 font-xxs">você ganhou <?= $valorGanhador[$i] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="roleta-premiada--roda<?= $i ?>" class="roleta-premiada--roda d-none" style="opacity: 1; scale: 1;">
    <div id="wheelOfFortune<?= $i ?>" class="wheelOfFortune">
        <audio id="spinAudio<?= $i ?>" src="/roleta.mp3" preload="true"></audio>
        <audio id="spinAudio-audio-ganhou<?= $i ?>" src="/roleta-ganhou.wav" preload="auto"></audio>
        <audio id="spinAudio-audio-perdeu<?= $i ?>" src="/roleta-perdeu.wav" preload="auto"></audio>
        <canvas id="wheel<?= $i ?>" width="350" height="350" style="transform: rotate(-1.5708rad);"></canvas>
        <div id="spin<?= $i ?>" class="spin" style="background: rgb(40, 63, 151); color: rgb(255, 255, 255); cursor: pointer;">Girar</div>
    </div>
</div>