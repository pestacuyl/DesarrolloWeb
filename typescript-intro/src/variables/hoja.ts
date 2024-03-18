// export class Persona {
//     // Propiedades de la clase public o private
//     public nombre: string;
//     public edad?: number;
//     public hijos?: number;

//     // Constructor de la clase
//     constructor(nombre: string, edad: number, hijos: number ) {
//         this.nombre = nombre;
//         this.edad = edad;
//         this.hijos = hijos
//     }

//     // Método de la clase para mostrar información
//     mostrarInformacion(): void {
//         console.log(`Nombre: ${this.nombre}, Edad: ${this.edad}, hijos: ${this.hijos}`);
//     }
// }

// export class hijos {
//     constructor(public nombre: string, public edad: number) {
//         this.nombre = nombre;
//         this.edad = edad;
//     }
// }


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
    carrera: string;

    constructor(nombre: string, edad: number, carrera: string) {
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



