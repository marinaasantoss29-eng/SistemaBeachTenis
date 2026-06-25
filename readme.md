*Sistema Beach Tenis

Sistema web em PHP para organizar torneios de Beach Tennis no formato Super 8. O projeto permite escolher o formato das duplas, cadastrar os 8 participantes, gerar rodadas automaticamente, lançar placares e acompanhar a classificação geral.

*Objetivo do projeto

O sistema foi criado para facilitar a organização de torneios rápidos de Beach Tennis, evitando controles manuais em papel ou planilhas. Ele centraliza o fluxo do torneio em uma aplicação simples, acessada pelo navegador, usando arquivos JSON para guardar participantes, rodadas e placares.

*Funcionalidades

- Escolha do formato do torneio:
  - Duplas rotativas: as duplas são sorteadas e mudam a cada rodada.
  - Duplas fixas: os jogadores são organizados em duplas permanentes.
- Cadastro obrigatório de 8 participantes.
- Registro de nome completo e apelido opcional.
- Validação para impedir nomes repetidos.
- Geração automática de 7 rodadas.
- Cada rodada possui 2 partidas, distribuídas em 2 quadras.
- Lançamento e edição de placares.
- Validação de placares entre 0 e 10.
- Bloqueio de empates.
- Tela de resultado por rodada.
- Classificação geral com pontos, vitórias, derrotas, games pró, games contra e saldo.
- Identificação do líder ou da dupla campeã.
- Impressão da classificação.
- Opção para reiniciar o torneio.

*Tecnologias usadas

- PHP
- HTML
- CSS
- JSON para armazenamento dos dados
- XAMPP

*Regras do torneio

O sistema trabalha com exatamente 8 participantes.

No formato de duplas rotativas, a classificação é calculada por jogador. As duplas mudam ao longo das rodadas, e cada jogador acumula seus próprios pontos.

No formato de duplas fixas, a classificação é calculada por dupla. Os participantes são agrupados em pares conforme a ordem do cadastro:

- Participantes 1 e 2 formam a primeira dupla.
- Participantes 3 e 4 formam a segunda dupla.
- Participantes 5 e 6 formam a terceira dupla.
- Participantes 7 e 8 formam a quarta dupla.

*Pontuação

A regra de pontuação usada pelo sistema é:

- Cada vitória vale 2 pontos extras.
- Cada game vencido vale 1 ponto.
- O saldo é calculado por `games pró - games contra`.

*Critérios de classificação

O ranking é ordenado nesta sequência:

1. Maior total de pontos.
2. Maior saldo de games.
3. Maior quantidade de games pró.

## Estrutura do projeto
super8/
├── index.php
├── reiniciar.php
├── classificacao/
│   └── classificacao.php
├── configuracao/
│   ├── configuracao.php
│   └── gerar_rodadas.php
├── css/
│   └── style.css
├── data/
│   ├── participantes.json
│   └── rodadas.json
├── participantes/
│   ├── cadastro.php
│   └── salvar_participantes.php
├── rodadas/
│   ├── resultado_rodada.php
│   ├── rodadas.php
│   └── salvar_placar.php
└── utils/
    ├── json_helper.php
    └── pontuacao.php
```
## Armazenamento de dados

O projeto não usa banco de dados. As informações são salvas em arquivos JSON:

- `super8/data/participantes.json`: lista dos participantes cadastrados.
- `super8/data/rodadas.json`: rodadas geradas, partidas e placares.

Ao reiniciar o torneio, esses arquivos são limpos.

## Observações

- O sistema não aceita placares empatados.
- Os placares devem estar entre 0 e 10.
- A classificação só considera partidas com placar preenchido.
- Para começar um novo torneio, use a opção `Reiniciar Torneio` na tela inicial.
