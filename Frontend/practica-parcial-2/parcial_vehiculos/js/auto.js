class Auto extends Vehiculo {
    cantidadPuertas;
    constructor(id, fabricante, modelo, añoLanzamiento, cantidadPuertas) {
      super(id, fabricante, modelo, añoLanzamiento);
      this.cantidadPuertas = cantidadPuertas;
    }
  
    toStringJson(conId) {
      const jsonToString = super.toStringJson(conId);
      const response = JSON.parse(jsonToString);
      return JSON.stringify({...response, cantidadPuertas: this.cantidadPuertas});
    }
  }
  