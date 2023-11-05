class Empleado extends Persona{
    sueldo="";
    ventas=0;

    constructor(sueldo, ventas, id, nombre, apellido, edad) {
        super(id, nombre, apellido, edad);
            this.sueldo = sueldo;
            this.ventas = ventas;
    }
    
    toString() {
        return `Empleado { id: ${this.id}, nombre: ${this.nombre}, apellido: ${this.apellido}, edad: ${this.edad}, sueldo: ${this.sueldo}, ventas: ${this.ventas} }`;
      }
    
    toJson() {
    return JSON.stringify({
        id: this.id,
        nombre: this.nombre,
        apellido: this.apellido,
        edad: this.edad,
        sueldo: this.sueldo,
        ventas: this.ventas
    });
    }
    
}