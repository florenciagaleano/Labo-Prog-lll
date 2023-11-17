const local = "http://localhost:80/labo3";
let arrayHeaders = new Array("ID", "FABRICANTE", "MODELO", "AÑO LANZAMIENTO", "CANTIDAD DE PUERTAS", "TRANSMISION 4X4", "MODIFICAR", "ELIMINAR");
let tabla = document.getElementById("tabla-vehiculos");
const $btnAgregar = document.getElementById("btnAgregar");
let $formAlta = document.getElementById("form-alta");
let esAlta = 1; //1 es alta, 0 es modificacion y -1 es eliminar
let arrayVehiculos = new Array();
let $btnAceptar = document.getElementById("btnAceptar");
let $btnCancelar = document.getElementById("btnCancelar");
const tipoVehiculoSelect = document.getElementById("tipo-vehiculo");
let $tipoOperacion = document.getElementById("tipoOperacion");
let spinner = document.getElementById("spinner");
let campoTransmision = document.getElementById("campoTransmision");
let campoPuertas = document.getElementById("campoPuertas");

window.addEventListener("load", () => {
    GetVehiculosJSON();
});

function agregarDatos() {
    limpiarTabla(tabla);
    tabla.appendChild(crearTabla(arrayVehiculos));

}

function limpiarTabla(tabla) {
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }
}

function crearTabla(arrayVehiculos) {
    const tabla = document.createElement("table");
    tabla.setAttribute("id", "tableVehiculos");
    tabla.appendChild(crearCabecera());
    crearCuerpo(arrayVehiculos, tabla);
    return tabla;
}

function crearCabecera() {
    const tHead = document.createElement("thead");
    const headRow = document.createElement("tr");

    arrayHeaders.forEach(headerText => {
        const th = document.createElement("th");
        th.textContent = headerText;
        headRow.appendChild(th);
    });

    tHead.appendChild(headRow);
    return tHead;
}

function crearCuerpo(data, tabla) {
    const tBody = document.createElement('tbody');
    tBody.setAttribute("id", "table-tbody");
    let fila;
    data.forEach(vehiculo => {
        const columnasData = filtrarData(data, vehiculo);
        CrearFila(columnasData, tBody);
    });
    tabla.appendChild(tBody);
}

function CrearFila(columnasData, tBody) {
    const fila = document.createElement("tr");
    columnasData.forEach(columnaInfo => {
        const elemento = document.createElement("td");
        elemento.appendChild(document.createTextNode(columnaInfo?.data ?? '-'));
        fila.appendChild(elemento);
    });
    agregarBotones(fila);
    tBody.appendChild(fila);
}

function agregarBotones(fila) {
    const elementoModificar = document.createElement("td");
    const elementoEliminar = document.createElement("td");

    let buttonModificar = document.createElement("button");
    let buttonEliminar = document.createElement("button");

    buttonModificar.textContent = "Modificar";
    buttonEliminar.textContent = "Eliminar";
    buttonModificar.addEventListener("click", () => {
        let filaClickeada = event.target.closest("tr");
        let idVehiculoClickeado = filaClickeada.querySelector("td:first-child") != null ? filaClickeada.querySelector("td:first-child").textContent : null;    //selecciono el primer elemento de la fila (el id)     
        cargarVehiculo(this.buscarVehiculoPorId(idVehiculoClickeado));
        mostrarFormularioABM("MODIFICAR");
        esAlta = 0;
    });

    buttonEliminar.addEventListener("click", () => {
        /*let filaClickeada = event.target.closest("tr");
        let idVehiculoClickeado = filaClickeada.querySelector("td:first-child") != null ? filaClickeada.querySelector("td:first-child").textContent : null;    //selecciono el primer elemento de la fila (el id)     
        cargarVehiculo(this.buscarVehiculoPorId(idVehiculoClickeado));
        mostrarFormularioABM("ELIMINAR");
        esAlta = -1;*/
    });

    elementoModificar.appendChild(buttonEliminar);
    elementoEliminar.appendChild(buttonModificar);
    fila.appendChild(elementoModificar);
    fila.appendChild(elementoEliminar);
}

function GetVehiculosJSON() {
    let endpoint = "/vehiculos.php";
    fetch(`${local}${endpoint}`)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error(`Error de red: ${response.statusText}`);
            }
        })
        .then(data => {
            arrayVehiculos = GetVehiculos(data);
            tabla.appendChild(crearTabla(arrayVehiculos));
        })
        .catch(error => {
            console.error('Error:', error);
            alert('No se pudo obtener la lista de vehículos. Intente de nuevo.');
        });
}

function GetVehiculos(data) {
    let arrayVehiculos = data.map(
        (elemento) => {
            if ('cantidadPuertas' in elemento) {
                return new Auto(elemento.id, elemento.fabricante, elemento.modelo,elemento.añoLanzamiento, elemento.cantidadPuertas);
            } else if ('transmision4x4' in elemento) {
                return new Camioneta(elemento.id, elemento.fabricante, elemento.modelo,elemento.añoLanzamiento, elemento.transmision4x4);
            } else {
                return new Vehiculo(elemento.id, elemento.fabricante, elemento.modelo,elemento.añoLanzamiento);
            }
        }
    );

    return arrayVehiculos;
}

function filtrarData(data, vehiculo) {
    let columnasData = [];

    const campos = {
        id: 'ID',
        fabricante: 'FABRICANTE',
        modelo: 'MODELO',
        añoLanzamiento: 'AÑO LANZAMIENTO',
        cantidadPuertas: 'CANTIDAD DE PUERTAS',
        transmision4x4: 'TRANSMISION 4X4',
    };

    for (const campo in campos) {
        if (campo === 'cantidadPuertas' && vehiculo instanceof Camioneta) {
            columnasData.push({ data: vehiculo[campo] || '-' });
        } else if (campo === 'transmision4x4' && vehiculo instanceof Auto) {
            columnasData.push({ data: vehiculo[campo] || '-' });
        } else {
            columnasData.push({ data: vehiculo[campo] });
        }
    }

    return columnasData;
}

$btnAgregar.addEventListener("click", (e) => {
    e.preventDefault();
    esAlta = 1;
    mostrarFormularioABM("ALTA");
});

$btnAceptar.addEventListener("click", (e) => {
    e.preventDefault();
    const nuevoVehiculo = obtenerDatosFormulario();
    ABMVehiculo(nuevoVehiculo);
    ocultarFormularioABM();
});

$btnCancelar.addEventListener("click", (e) => {
    e.preventDefault();
    ocultarFormularioABM();
});

function ocultarFormularioABM() {
    $formAlta.hidden = true;
    tabla.hidden = false;
    $btnAgregar.hidden = false;
    $tipoOperacion.textContent = "ALTA";
}

function mostrarFormularioABM(operacion) {
    $formAlta.hidden = false;
    tabla.hidden = true;
    $btnAgregar.hidden = true;
    $tipoOperacion.textContent = operacion;
}

function ABMVehiculo(vehiculo) {
    switch (esAlta) {
        case 1:
            agregarVehiculo(vehiculo);
            break;
        case 0:
            modificarVehiculo(vehiculo);
            break;
        case -1:
            eliminarVehiculo(vehiculo.id);
            break;
    }
}

function obtenerDatosFormulario() {
    const data = {
        fabricante: document.getElementById("txtFabricante").value,
        modelo: document.getElementById("txtModelo").value,
        añoLanzamiento: parseInt(document.getElementById("txtañoLanzamiento").value),
    };

    const tipo = tipoVehiculoSelect.value;
    const id = parseInt(document.getElementById("txtId").value);
    if(!isNaN(id)){
        data.id = parseInt(document.getElementById("txtId").value);
    }

    let retorno = null;
    switch (tipo) {
      case 'auto':
        data.cantidadPuertas = parseInt(document.getElementById("txtPuertas").value);
        retorno = new Auto(data.id, data.fabricante, data.modelo, data.añoLanzamiento, data.cantidadPuertas);
        break;
      case 'camioneta':
        data.transmision4x4 = document.querySelector('input[name="radioTransmision"]:checked')?.value;
        retorno = new Camioneta(data.id, data.fabricante, data.modelo, data.añoLanzamiento, data.transmision4x4);
        break;
    }
    return retorno;
}
  
tipoVehiculoSelect.addEventListener("change", function() {
    const tipoSeleccionado = tipoVehiculoSelect.value;

    let campoTransmision = document.getElementById("campoTransmision");

    if (tipoSeleccionado === "auto") {
        campoPuertas.style.display = "block"; 
        campoTransmision.style.display = "none";
    } else if (tipoSeleccionado === "camioneta") {
        campoPuertas.style.display = "none"; 
        campoTransmision.style.display = "block";
    }
});

function agregarVehiculo(data) {
    let endpoint = data instanceof Auto ? "insertarauto.php" : "insertarcamioneta.php";
    data = JSON.parse(data.toStringJson(true));
    console.log(data);
    const xhr = new XMLHttpRequest();
    xhr.open("PUT", `${local}/${endpoint}`, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            ocultarSpinner();
            if (xhr.status == 200) {
                const jsonResponse = JSON.parse(xhr.responseText);
                data.id = jsonResponse.id;
                arrayVehiculos.push(data);
                agregarDatos();
                ocultarFormularioABM();
            } else {
                console.error("Error:", xhr);
                alert("No se pudo realizar la operación :(");
            }
        }
    };

    mostrarSpinner();

    const requestBody = { ...data };
    delete requestBody.id;

    const jsonData = JSON.stringify(requestBody);
    xhr.send(jsonData);
}

function cargarVehiculo(vehiculo) {
    let fabricanteTxt = document.getElementById("txtFabricante");
    fabricanteTxt.value = vehiculo.fabricante;

    let modeloTxt = document.getElementById("txtModelo");
    modeloTxt.value = vehiculo.modelo;

    let añoLanzamientoTxt = document.getElementById("txtañoLanzamiento");
    añoLanzamientoTxt.value = vehiculo.añoLanzamiento;
    console.log(vehiculo);
    if (vehiculo.cantidadPuertas) {
        tipoVehiculoSelect.value = "auto";
        let puertasTxt = document.getElementById("txtPuertas");
        puertasTxt.value = vehiculo.cantidadPuertas;
        document.getElementById("campoTransmision").style.display = "none";
        document.getElementById("campoPuertas").style.display = "block";
    } else if (vehiculo.transmision4x4) {
        tipoVehiculoSelect.value = "camioneta";
        document.getElementById("campoPuertas").style.display = "none";
        document.getElementById("campoTransmision").style.display = "block";
        let transmisionRadio = document.querySelector(`input[value="${vehiculo.transmision4x4}"]`);
        if (transmisionRadio) {
            transmisionRadio.checked = true;
        }
    }

}

function buscarVehiculoPorId(id) {
    if (id != null) {
        let idTxt = document.getElementById("txtId");
        idTxt.value = id;
    }
    return arrayVehiculos.filter(vehiculo => vehiculo.id == id)[0];
}

async function modificarVehiculo(data) {
    let endpoint = data instanceof Auto ? "modificarauto.php" : "modificarcamioneta.php";
    data = JSON.parse(data.toStringJson(true));
    mostrarSpinner();

    try {

        const req  = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        };
        let response = await fetch(`${local}/${endpoint}`, req);

        if (response .status == 200) {
            arrayVehiculos = arrayVehiculos.map(vehiculo => {
                if (vehiculo.id === data.id)
                  return data;
                return vehiculo;
              });
            agregarDatos();
            ocultarFormularioABM();
        } else {
            console.error('Error:', response);
            alert('No se pudo realizar la operación :(');
        }
    } catch (error) {
        console.log(data);
        console.error('Error:', error);
        alert('No se pudo realizar la operación :(');
    } finally {
        ocultarSpinner();
    }
}

/*  SPINNER */
function mostrarSpinner() {
    const spinner = document.getElementById("spinner");
    spinner.style.display = "block";
}

function ocultarSpinner() {
    const spinner = document.getElementById("spinner");
    spinner.style.display = "none";
}