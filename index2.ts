// Tipos de variables
const varString: string = "hola";
const varChar: string = "h"; // No existe un tipo de dato 'char' en TypeScript, utiliza 'string'
const numero: number = 21;

// Tipos de datos
const booleano2: boolean = true;
const arregloNumeros: number[] = [1, 2, 3];
const arregloStrings: string[] = ["uno", "dos", "tres"];
const tupla2: [string, number] = ["hola", 5];
const objeto: { nombre: string, edad: number } = { nombre: "Juan", edad: 25 };

// Forma de expresar
console.log(varString);
console.log(varChar);
console.log(numero);
console.log(booleano2);
console.log(arregloNumeros);
console.log(arregloStrings);
console.log(tupla2);
console.log(objeto);


// index.ts

function saludar() {
  const mensaje: string = "¡Hola, Mundo!" + varString;
  console.log(mensaje);

  const contenedor = document.getElementById("mensaje");
  if (contenedor) {
    contenedor.innerHTML = mensaje;
    // Aplicar efecto de desenfoque
    //contenedor.style.filter = "blur(5px)";
    contenedor.style.color = "blue";
  }
}

saludar();
export {};