const local = "http://localhost:80/";
let arrayHeaders = new Array("ID", "NOMBRE", "APELLIDO", "EDAD", "VENTAS", "SUELDO", "COMPRAS", "TELEFONO", "MODIFICAR", "ELIMINAR");
let tabla = document.getElementById("tabla-personas");

window.addEventListener("load", () => {
    GetPersonasJSON();
});

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
            console.log(JSON.parse(xhttp.response));
            const data = JSON.parse(xhttp.response);
            let arrayPersonas = GetPersonas(data);
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
