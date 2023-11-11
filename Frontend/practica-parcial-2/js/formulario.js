const local = "http://localhost:80/";
let arrayHeaders = new Array("ID", "NOMBRE", "APELLIDO", "EDAD", "VENTAS", "SUELDO", "COMPRAS", "TELEFONO", "MODIFICAR", "ELIMINAR");
let tabla = document.getElementById("tabla-personas");
const $btnAgregar = document.getElementById("btnAgregar");
let $formAlta = document.getElementById("form-alta");
let esAlta = 1; //1 es alta, 0 es modificacion y -1 es eliminar
let arrayPersonas = new Array();
let $btnAceptar = document.getElementById("btnAceptar");
let $btnCancelar = document.getElementById("btnCancelar");

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

    // Itera sobre los campos y agrega los que estén marcados en el checkbox
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
    $formAlta.hidden = false;
    campoVentas.style.display = "none";
    campoCompras.style.display = "block";
    campoSueldo.style.display = "none";
    campoTelefono.style.display = "block";
});

$btnAceptar.addEventListener("click", (e) => {
    e.preventDefault();
    const nuevaPersona = obtenerDatosFormulario();
    agregarPersona(nuevaPersona);
    $formAlta.hidden = true;
});

function agregarPersona(data) {
    let endpoint = "labo3/PersonasEmpleadosClientes.php";
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log(xhttp.responseText);
                const jsonResponse = JSON.parse(xhttp.responseText);
                data.id = jsonResponse.id;
                arrayPersonas.push(data);
                agregarDatos();
            } else {
                console.error("Error:", xhttp.statusText);
            }
        }
    };

    xhttp.open("PUT", `${local}${endpoint}`, true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(data));
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
