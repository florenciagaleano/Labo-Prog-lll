const local = "http://localhost:80/";
let arrayHeaders = new Array("ID", "NOMBRE", "APELLIDO", "EDAD", "VENTAS", "SUELDO", "COMPRAS", "TELEFONO", "MODIFICAR", "ELIMINAR");
let tabla = document.getElementById("tabla-personas");
const $btnAgregar = document.getElementById("btnAgregar");
let $formAlta = document.getElementById("form-alta");
let esAlta = 1; //1 es alta, 0 es modificacion y -1 es eliminar
let arrayPersonas = new Array();
let $btnAceptar = document.getElementById("btnAceptar");
let $btnCancelar = document.getElementById("btnCancelar");
const tipoPersonaSelect = document.getElementById("tipo-persona");
let $tipoOperacion = document.getElementById("tipoOperacion");
let spinner = document.getElementById("spinner");

/*Campos form ABM*/
/*const campoVentas = document.getElementById("campoVentas");
const campoSueldo = document.getElementById("campoSueldo");
const campoCompras = document.getElementById("campoCompras");
const campoTelefono = document.getElementById("campoTelefono");*/


window.addEventListener("load", () => {
    GetPersonasJSON();
});

function agregarDatos() {
    limpiarTabla(tabla);
    tabla.appendChild(crearTabla(arrayPersonas));

}

function limpiarTabla(tabla) {
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }
}

function crearTabla(arrayPersonas) {
    const tabla = document.createElement("table");
    tabla.setAttribute("id", "tablePersonas");
    tabla.appendChild(crearCabecera());
    crearCuerpo(arrayPersonas, tabla);
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
    data.forEach(persona => {
        const columnasData = filtrarData(data, persona);
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
        let idPersonaClickeada = filaClickeada.querySelector("td:first-child") != null ? filaClickeada.querySelector("td:first-child").textContent : null;    //selecciono el primer elemento de la fila (el id)     
        cargarPersona(this.buscarPersonaPorId(idPersonaClickeada));
        mostrarFormularioABM("MODIFICAR");
        esAlta = 0;
    });

    buttonEliminar.addEventListener("click", () => {
        let filaClickeada = event.target.closest("tr");
        let idPersonaClickeada = filaClickeada.querySelector("td:first-child") != null ? filaClickeada.querySelector("td:first-child").textContent : null;    //selecciono el primer elemento de la fila (el id)     
        cargarPersona(this.buscarPersonaPorId(idPersonaClickeada));
        mostrarFormularioABM("ELIMINAR");
        esAlta = -1;
    });

    elementoModificar.appendChild(buttonEliminar);
    elementoEliminar.appendChild(buttonModificar);
    fila.appendChild(elementoModificar);
    fila.appendChild(elementoEliminar);
}

function GetPersonasJSON() {
    var xhttp = new XMLHttpRequest();
    let endpoint = "labo3/PersonasEmpleadosClientes.php";
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            const data = JSON.parse(xhttp.response);
            arrayPersonas = GetPersonas(data);
            tabla.appendChild(crearTabla(arrayPersonas));
        }
    };
    xhttp.open("GET", `${local}${endpoint}`, true);
    xhttp.send();
}

function GetPersonas(data) {
    let arrayPersonas = data.map(
        (elemento) => {
            if ('ventas' in elemento && 'sueldo' in elemento) {
                return new Empleado(elemento.sueldo, elemento.ventas, elemento.id, elemento.nombre, elemento.apellido, elemento.edad);
            } else if ('compras' in elemento && 'telefono' in elemento) {
                return new Cliente(elemento.compras, elemento.telefono, elemento.id, elemento.nombre, elemento.apellido, elemento.edad);
            } else {
                return new Persona(elemento.id, elemento.nombre, elemento.apellido, elemento.edad);
            }
        }
    );

    return arrayPersonas;
}

function filtrarData(data, persona) {
    let columnasData = [];

    // Define un objeto que mapea los campos a sus nombres
    const campos = {
        id: 'ID',
        nombre: 'NOMBRE',
        apellido: 'APELLIDO',
        edad: 'EDAD',
        ventas: 'VENTAS',
        sueldo: 'SUELDO',
        compras: 'COMPRAS',
        telefono: 'TELEFONO'
    };

    for (const campo in campos) {
        if ((campo === 'ventas' || campo === 'sueldo') && persona instanceof Empleado) {
            columnasData.push({ data: persona[campo] || 'N/A' });
        } else if ((campo === 'compras' || campo === 'telefono') && persona instanceof Cliente) {
            columnasData.push({ data: persona[campo] || 'N/A' });
        } else {
            columnasData.push({ data: persona[campo] });
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
    const nuevaPersona = obtenerDatosFormulario();
    ABMPersona(nuevaPersona);
    ocultarFormularioABM();
});

$btnCancelar.addEventListener("click", (e) => {
    e.preventDefault();
    ocultarFormularioABM();
});

function ABMPersona(persona){
    switch(esAlta){
        case 1:
            agregarPersona(persona);
            break;
        case 0:
            modificarPersona(persona);
            break;
        case -1:
            eliminarPersona(persona.id);
            break;
    }
}

function agregarPersona(data) {
    let endpoint = "labo3/PersonasEmpleadosClientes.php";
    const req = {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    };

    mostrarSpinner();

    fetch(`${local}${endpoint}`, req)
        .then(response => {
            ocultarSpinner();
            if (response.ok) {
                return response.json();
            } else {
                console.error("Error:", response.statusText);
                alert("No se pudo realizar la operacion :(");
                throw new Error("Operación fallida");
            }
        })
        .then(jsonResponse => {
            data.id = jsonResponse.id;
            arrayPersonas.push(data);
            agregarDatos();
            ocultarFormularioABM();
        })
        .catch(error => {
            console.error("Error:", error.message);
        });
}

function obtenerDatosFormulario() {
    const id = document.getElementById("txtId").value;
    const nombre = document.getElementById("txtNombre").value;
    const apellido = document.getElementById("txtApellido").value;
    const edad = document.getElementById("txtEdad").value;
    const ventas = document.getElementById("txtVentas").value;
    const sueldo = document.getElementById("txtSueldo").value;
    const compras = document.getElementById("txtCompras").value;
    const telefono = document.getElementById("txtTelefono").value;


    return {
        id,
        nombre,
        apellido,
        edad,
        ventas,
        sueldo,
        compras,
        telefono,
    };
}

function buscarPersonaPorId(id) {
    if (id != null) {
        let idTxt = document.getElementById("txtId");
        idTxt.value = id;
    }
    return arrayPersonas.filter(persona => persona.id == id)[0];
}

function cargarPersona(persona){
    let nombreTxt = document.getElementById("txtNombre");
    nombreTxt.value = persona.nombre;

    let apellidoTxt = document.getElementById("txtApellido");
    apellidoTxt.value = persona.apellido;

    let edadTxt = document.getElementById("txtEdad");
    edadTxt.value = persona.edad;

    if(persona instanceof Cliente){
        let comprasTxt = document.getElementById("txtCompras");
        comprasTxt.value = persona.compras;
        
        let telefonoTxt = document.getElementById("txtTelefono");
        telefonoTxt.value = persona.telefono;
        cambiarBotonesPorTipo("cliente");
    }else{
        let ventasTxt = document.getElementById("txtVentas");
        ventasTxt.value = persona.ventas;
        
        let sueldoTxt = document.getElementById("txtSueldo");
        sueldoTxt.value = persona.sueldo;
        cambiarBotonesPorTipo("empleado");
    }
}

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

tipoPersonaSelect.addEventListener("change", function() {
    const tipoSeleccionado = tipoPersonaSelect.value;

    cambiarBotonesPorTipo(tipoSeleccionado);
    
});

function cambiarBotonesPorTipo(tipo){
    if (tipo === "empleado") {
        campoVentas.style.display = "block";
        campoSueldo.style.display = "block";
        campoCompras.style.display = "none";
        campoTelefono.style.display = "none";
    } else if (tipo === "cliente") {
        campoVentas.style.display = "none";
        campoSueldo.style.display = "none";
        campoCompras.style.display = "block";
        campoTelefono.style.display = "block";
    }
}

async function modificarPersona(persona) {
    mostrarSpinner();

    let endpoint = "labo3/PersonasEmpleadosClientes.php";
    const constRequestDetail = {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(persona)
    };

    let requestUrl = local + endpoint;

    try {
        let response = await fetch(requestUrl, constRequestDetail);

        if (response.status == 200) {
            // Actualizar ID, elemento de la lista, etc.
            agregarDatos();
        } else {
            console.error("Error:", response.statusText);
            alert("No se pudo realizar la operación. Intente de nuevo.");
        }
    } catch (error) {
        console.error("Error:", error.message);
        alert("Hubo un error. Intente de nuevo.");
    } finally {
        ocultarSpinner();
    }
}

async function eliminarPersona(id) {
    mostrarSpinner();

    let endpoint = "labo3/PersonasEmpleadosClientes.php";
    const req = {
        method: 'DELETE',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(id)
    };

    let requestUrl = local + endpoint;

    try {
        let response = await fetch(requestUrl, req);

        if (response.status == 200) {
            agregarDatos();
        } else {
            console.error("Error:", response);
            alert("No se pudo realizar la operación. Intente de nuevo.");
        }
    } catch (error) {
        console.error("Error:", error.message);
        alert("Hubo un error. Intente de nuevo.");
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
