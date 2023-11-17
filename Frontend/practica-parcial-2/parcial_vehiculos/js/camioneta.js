class Camioneta extends Vehiculo {
    transmision4x4;
    constructor(id, fabricante, modelo, añoLanzamiento, transmision4x4) {
      super(id, fabricante, modelo, añoLanzamiento);
      this.transmision4x4 = transmision4x4;
    }
  
    toStringJson(conId) {
      const jsonToString = super.toStringJson(conId);
      const response = JSON.parse(jsonToString);
      return JSON.stringify({ ...response, transmision4x4: this.transmision4x4 });
    }
  }
  
  