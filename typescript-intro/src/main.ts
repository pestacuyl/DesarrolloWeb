import './style.css'
//import typescriptLogo from './typescript.svg'
//import viteLogo from '/vite.svg'
import { setupCounter } from './counter.ts'
import './variables/basico.ts'

document.querySelector<HTMLDivElement>('#app')!.innerHTML = `
  <div class='dashboard'>
    <div id='header'></div>
    <div>
      <div id='slider'></div>
      <div id='body'></div>
    </div>
    <div id='footer'></div>
  </div>
`;

document.querySelector<HTMLDivElement>('#header')!.innerHTML = `
<div class="ui inverted menu">
  <a class="item" href=#header>Inicio</a>
  <a class="item" href=#body>Acerca de</a>
  <a class="item" href=#footer>Servicios</a>
  <a class="item" href=#footer>Contacto</a>
</div>
`;

document.querySelector<HTMLDivElement>('#body')!.innerHTML = `
<div class="ui inverted menu">
  <p id='counter'></p>
</div>
`;

setupCounter(document.querySelector<HTMLButtonElement>('#counter')!);