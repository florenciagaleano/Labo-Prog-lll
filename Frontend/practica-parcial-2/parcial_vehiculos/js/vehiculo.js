class Vehiculo {
    id;
    fabricante;
    modelo;
    añoLanzamiento;
    constructor(id, fabricante, modelo, añoLanzamiento) {
      this.id = parseInt(id);
      this.fabricante = fabricante;
      this.modelo = modelo;
      this.añoLanzamiento = añoLanzamiento;
    }
  
    toStringJson(conId) {
      let response = {fabricante: this.fabricante, modelo: this.modelo, añoLanzamiento: this.añoLanzamiento};
      if(conId)
        response.id = this.id;
      return JSON.stringify(response);
    }
  }