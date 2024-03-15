export function setupCounter(element: HTMLButtonElement) {
  let counter = 0;
  
  // Verificar si el elemento existe antes de intentar agregar el event listener
  if (element) {
    const setCounter = (count: number) => {
      counter = count;
      element.innerHTML = `la cuenta es ${counter}`;
    };
    
    element.addEventListener('click', () => setCounter(counter + 1));
    setCounter(0);
  } else {
    console.error("El elemento no fue encontrado en el DOM.");
  }
}
