class Cliente extends Persona{
    telefono="";
    compras=0;

    constructor(compras, telefono, id, nombre, apellido, edad) {
        super(id, nombre, apellido, edad);
            this.compras = compras;
            this.telefono = telefono;
    }
    
    toString() {
        return `Cliente { id: ${this.id}, nombre: ${this.nombre}, apellido: ${this.apellido}, edad: ${this.edad}, compras: ${this.compras}, telefono: ${this.telefono} }`;
      }
    
    toJson() {
    return JSON.stringify({
        id: this.id,
        nombre: this.nombre,
        apellido: this.apellido,
        edad: this.edad,
        compras: this.compras,
        telefono: this.telefono
    });
    }
    
}