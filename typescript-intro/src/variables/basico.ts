/*
    ===== Código de TypeScript =====
*/
//destructuracion de objetos
interface SuperHero{
    name: string;
    age: number;
    address: Address;
    showAddress: () => string;
}

interface Address{
    calle: string;
    pais: string;
    ciudad:string;
}

const superHeroe: SuperHero = {
    name: 'Spiderman',
    age: 30,
    address: {
        calle: 'Main St',
        pais: 'USA',
        ciudad: 'NY'
    },
    showAddress() {
        return this.name + ', ' + this.address.ciudad + ', ' + this.address.pais;
    }
}


const address = superHeroe.showAddress();
console.log( address );


 const {name: names, age: ageEdad, address: direccion} = superHeroe;
 const {calle} = direccion;

 console.log(names);
 console.log(ageEdad);
 console.log(calle);



//destructuracion de arreglos

const dbz : string[] = ['Goku', 'Vegeta', 'Trunks'];

const [,,Trunks]=dbz;

console.log('personaje 3: ', Trunks);


/*
    ===== Ejercicio =====
*/
//destructuracion de argumentos

interface Product{
    descripcion: string;
    precio: number;
};

const telefono: Product ={
    descripcion: 'nokia',
    precio: 150
};

const tableta: Product ={
    descripcion: 'ipad',
    precio: 250
};

interface IVACalculo {
    iva: number;
    product: Product[];
};

function calculoIVA(opcion: IVACalculo): number[]{
    let total = 0;
    opcion.product.forEach( product =>{
        total += product.precio;
    });
    return [total, total * opcion.iva];
};

const TarjetaDeCompra = [telefono, tableta];
const iva = 0.12;

const resultado: any = calculoIVA({
    product: TarjetaDeCompra,
    iva: iva,
});
console.log('Total =', resultado[0]);
console.log('Total =', resultado[1]);



/*
    ===== Ejercicio Resuelto =====

//destructuracion de argumentos

interface Product{
    descripcion: string;
    precio: number;
};

const telefono: Product ={
    descripcion: 'nokia',
    precio: 150,
};

const tableta: Product ={
    descripcion: 'ipad',
    precio: 250,
};

interface IVACalculo {
    iva: number;
    product: Product[];
};

function calculoIVA(opcion: IVACalculo): [number, number]{
//function calculoIVA({iva, product}: IVACalculo): [number, number]{
    const {iva, product}= opcion;
    let total = 0;
    product.forEach( ({precio}) =>{
        total += precio;
    });
    return [total, total * iva];
};

const TarjetaDeCompra: Product[] = [telefono, tableta];
const iva = 0.12;

const [total, ivaTotal]: any = calculoIVA({
    product: TarjetaDeCompra,
    iva: iva,
});

//console.log('Total =', resultado[0]);
console.log('Total =', total);

//console.log('Total =', resultado[1]);
console.log('Total =', ivaTotal);
*/


/*
    ===== Exportacion =====
*/

//export{};
export interface escuela{
    nombre: string,
    profesion: string,
    edad: number,
    seccion: string,
};





//import {escuela} from './basico.ts'
const persona: escuela={
    nombre : 'Mariano',
    profesion : 'profesor',
    edad : 34,
    seccion : 'c',
};

console.log({persona});

