let som;
let fft;
let pontosPista = [];
let progresso = 0;
let velocidadeEsfera = 0.002;

function preload() {
  som = loadSound('sua_musica.mp3'); 
}

function setup() {
  createCanvas(600, 600);
  
  fft = new p5.FFT();
  som.play();
  pontosPista = [
    createVector(450, 150),
    createVector(430, 100),
    createVector(300, 50),
    createVector(250, 120),
    createVector(220, 200),
    createVector(280, 250),
    createVector(220, 280),
    createVector(310, 480),
    createVector(350, 550),
    createVector(400, 530),
    createVector(450, 450),
    createVector(420, 300)
  ];
}

function draw() {
  background(20, 30, 20, 40); 

  fft.analyze();
  let volumeGrave = fft.getEnergy("bass"); 

  oFill();
  stroke(130, 255, 50); 
  strokeWeight(6);
  
  beginShape();
  for (let p of pontosPista) {
    curveVertex(p.x, p.y); 
  }
  endShape(CLOSE);

  progresso += velocidadeEsfera;
  if (progresso > 1) progresso = 0; 

  let pos = calcularPosicaoNaCurva(pontosPista, progresso);

  let tamanhoBolinha = 12 + map(volumeGrave, 0, 255, 0, 15);
  
  noStroke();
  fill(130, 255, 50, 50); // Verde neon transparente
  ellipse(pos.x, pos.y, tamanhoBolinha * 2.5);
  fill(130, 255, 50, 100);
  ellipse(pos.x, pos.y, tamanhoBolinha * 1.8);

  fill(255);
  ellipse(pos.x, pos.y, tamanhoBolinha);
}

function calcularPosicaoNaCurva(pontos, prog) {
  let total = pontos.length;
  let index = floor(prog * (total - 1));
  let restante = (prog * (total - 1)) - index;
  
  let p1 = pontos[index];
  let p2 = pontos[min(index + 1, total - 1)];
  
  let x = lerp(p1.x, p2.x, restante);
  let y = lerp(p1.y, p2.y, restante);
  
  return createVector(x, y);
}
