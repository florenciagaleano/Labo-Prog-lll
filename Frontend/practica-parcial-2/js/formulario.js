const local = "http://localhost:80/";
let arrayHeaders = new Array("ID", "NOMBRE", "APELLIDO", "EDAD", "VENTAS", "SUELDO", "COMPRAS", "TELEFONO");
let tabla = document.getElementById("tabla-personas");

window.addEventListener("load", async () => {
    const data = await GetPersonasJSON();
    const arrayPersonas = GetPersonas(data);
    tabla.appendChild(crearTabla(arrayPersonas));
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

    tBody.appendChild(fila);
}

async function GetPersonasJSON() {
    let endpoint = "labo3/PersonasEmpleadosClientes.php";
    console.log(`${local}${endpoint}`);
    try {
        const response = await fetch(`${local}${endpoint}`, { method: 'GET' });
        if (response.status === 200) {
            console.log(response);
            const data = await response.json();
            return data;
        } else {
            console.log('No se pudo hacer la petición');
            return null;
        }
    } catch (error) {
        console.log('Hubo un problema con la petición: ' + error.message);
        return null;
    }
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
                columnasData.push({ data: persona[campo] || '-' });
            } else if ((campo === 'compras' || campo === 'telefono') && persona instanceof Cliente) {
                columnasData.push({ data: persona[campo] || '-' });
            } else {
                columnasData.push({ data: persona[campo] });
            }
    }

    return columnasData;
}