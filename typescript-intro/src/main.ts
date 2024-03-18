import './style.css'
// import { Persona, hijos} from './variables/hoja';


// // Creación de una instancia u objeto de la clase Persona
// let persona1: Persona = new Persona("Juan", 25, 3);

// // Acceso a las propiedades y métodos del objeto persona1
// console.log('Nombre: ' + persona1.nombre); // Salida: Juan
// console.log('Edad: ' + persona1.edad);   // Salida: 25
// persona1.mostrarInformacion(); // Salida: Nombre: Juan, Edad: 25



//Ejemplo 1: Definición de una Clase Persona:
class Persona {
    public nombre: string;
    public edad: number;

    constructor(nombre: string, edad: number) {
        this.nombre = nombre;
        this.edad = edad;
    }

    saludar(): void {
        console.log(`Hola, soy ${this.nombre} y tengo ${this.edad} años.`);
    }
}

// Uso de la clase Persona
const persona1 = new Persona("Juan", 25);
persona1.saludar(); // Salida: Hola, soy Juan y tengo 25 años.

 //Ejemplo 2: Herencia en TypeScript:
class Estudiante extends Persona {
    public carrera: string;

    constructor( nombre: string, edad: number,  carrera: string) {
        super(nombre, edad);
        this.carrera = carrera;
    }

    presentarse(): void {
        console.log(`Hola, soy ${this.nombre}, tengo ${this.edad} años y estudio ${this.carrera}.`);
    }
}

// Uso de la clase Estudiante
const estudiante1 = new Estudiante("María", 20, "Ingeniería");
estudiante1.presentarse(); // Salida: Hola, soy María, tengo 20 años y estudio Ingeniería.


class Calculadora {
  static sumar(a: number, b: number): number {
      return a + b;
  }
}

// Uso del método estático
const resultado = Calculadora.sumar(5, 3);
console.log(resultado); // Salida: 8


class CuentaBancaria {
  private saldo: number;

  constructor(saldoInicial: number) {
      this.saldo = saldoInicial;
  }

  depositar(monto: number): void {
      this.saldo += monto;
  }

  retirar(monto: number): void {
      if (monto <= this.saldo) {
          this.saldo -= monto;
      } else {
          console.log("Saldo insuficiente.");
      }
  }

  consultarSaldo(): void {
      console.log(`Saldo actual: ${this.saldo}`);
  }
}

// Uso de la clase CuentaBancaria
const cuenta = new CuentaBancaria(1000);
cuenta.depositar(500);
cuenta.retirar(200);
cuenta.consultarSaldo(); // Salida: Saldo actual: 1300



