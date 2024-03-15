// Tipos de variables
const cConstante: string = "valor constante";
let lVariable: number = 42;
var vVariableGlobal: boolean = true; // No es recomendado, utiliza 'let' o 'const'

// Tipos de objetos
const cPersona: { nombre: string, edad: number } = { nombre: "Juan", edad: 25 };

// Tipos de arreglos
const cNumeros: number[] = [1, 2, 3];
const cPalabras: string[] = ["uno", "dos", "tres"];
const cMixto: (string | number)[] = ["uno", 2, "tres"];

// Tipos de interfaces
interface iPersona {
  nombre: string;
  edad?: number;
}

const cUsuario: iPersona = { nombre: "Ana", edad: 30 };

// Tipos de datos
const cCadena: string = "Hola";
const cNumeroEntero: number = 42;
const cFlotante: number = 3.14;
const cBooleano: boolean = true;
const cFecha: Date = new Date();

// Tipos de unión
const cResultado: string | number = Math.random() > 0.5 ? "Éxito" : 42;

// Tipos de tupla
const cTupla: [string, number] = ["hola", 5];

// Tipos condicionales
const cVariableCond: number = Math.random() > 0.5 ? 42 : 0;

// Tipos nulos y undefined
let lNulo: null = null;
let lIndefinido: undefined = undefined;

// Forma de expresar
console.log(cConstante);
console.log(lVariable);
console.log(vVariableGlobal);
console.log(cPersona);
console.log(cNumeros);
console.log(cPalabras);
console.log(cMixto);
console.log(cUsuario);
console.log(cCadena);
console.log(cNumeroEntero);
console.log(cFlotante);
console.log(cBooleano);
console.log(cFecha);
console.log(cResultado);
console.log(cTupla);
console.log(cVariableCond);
console.log(lNulo);
console.log(lIndefinido);




// Formas avanzadas de expresar variables
const varString2: string = "hola";

// Propiedades opcionales con '?'
interface Persona {
  nombre: string;
  edad?: number; // Propiedad opcional
}

const persona1: Persona = { nombre: "Juan" };
const persona2: Persona = { nombre: "Ana", edad: 25 };

// Tipos de unión con '|'
type Resultado = number | string;

const resultado1: Resultado = 42;
const resultado2: Resultado = "Hola";

// Tipos condicionales con 'typeof'
const variable2 = Math.random() > 0.5 ? "Hola" : 42;
type TipoVariable = typeof variable2;

// Valores nulos y undefined
let variableNula: null = null;
let variableIndefinida: undefined = undefined;

// Tipo 'never' para funciones que nunca retornan
function error(mensaje: string): never {
  throw new Error(mensaje);
}

// Tipo 'unknown' para valores de tipo desconocido
let valorDesconocido: unknown;
valorDesconocido = "Hola";
valorDesconocido = 42;

// Type assertion para indicar el tipo a TypeScript
const longitudCadena: number = (valorDesconocido as string).length;

console.log(varString2);
console.log(persona1);
console.log(persona2);
console.log(resultado1);
console.log(resultado2);
console.log(variableNula);
console.log(variableIndefinida);
console.log(longitudCadena);


export {};