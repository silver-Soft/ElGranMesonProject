document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    const basePath = "/" + window.location.pathname.split("/")[1];

    // Diccionario de descripciones según el ID
    const descripciones = {
        1: {
            texto: "Un corte doble de res (solomillo y lomo) sazonado con sal gruesa y pimienta negra, cocinado lentamente a la parrilla sobre brasas de mezquite. Se deja sellar para formar una costra caramelizada, conservando su jugosidad interna. Reposado antes de servir para realzar los jugos naturales de la carne.",
            imagen: basePath +"/img/platillos/tbone.webp"
        },
        2: {
            texto: "Pechuga de pollo marinada en especias cítricas, cocida lentamente en sartén de hierro hasta formar una capa dorada. Se acompaña de un bouquet de verduras seleccionadas (pimientos, zanahorias baby, calabacitas y espárragos) asadas al carbón, conservando textura y sabor ahumado.",
            imagen: basePath + "/img/platillos/pechuga.webp"
        },
        3: {
            texto: "Trozos de res sellados a fuego alto, cocinados a fuego lento en una mezcla de vino tinto, ajo, cebolla y hierbas provenzales hasta lograr una textura melosa. Se sirve sobre una base de hortalizas glaseadas (zanahorias baby, nabos, cebollitas) con mantequilla y reducción del propio estofado.",
            imagen: basePath + "/img/platillos/estofado.webp"
        },
        4: {
            texto: "Pasta al dente mezclada con un ragú espeso de carne de res cocinada por horas en sofrito de tomate natural, ajo, vino y bouquet garni. Terminada con un salteado final junto a hierbas frescas como albahaca, tomillo y orégano, para lograr una mezcla intensa y perfumada.",
            imagen: basePath + "/img/platillos/espagueti.webp"
        },
        5: {
            texto: "Corte grueso con hueso largo, sellado y cocinado a fuego indirecto para conservar su ternura. Acompañado con ajo confitado en aceite de oliva, se baña con mantequilla derretida infusionada con romero, tomillo y sal de mar en hojuelas. Reposado para realzar jugos.",
            imagen: basePath + "/img/platillos/carne_salsa.webp"
        },
        6: {
            texto: "Camarones frescos marinados en ajo y limón, salteados y colocados sobre cama crujiente de lechuga. Servidos sobre totopos artesanales acompañados de frijoles refritos al estilo norteño con mezcla de quesos gratinados (menonita y cheddar). Finalizado al horno para fundir los sabores.",
            imagen: basePath + "/img/platillos/carne_frita.webp"
        },
        7: {
            texto: "Cachaça mezclada con jugo natural de naranja, azúcar y rodajas de naranja maceradas. Agitada con hielo y servida con ramita de romero fresco flameado, que libera un perfume herbal intenso al momento de servir.",
            imagen: basePath + "/img/bebidas/caipirinha_rodajas.webp"
        },
        8: {
            texto: "Combinación de cachaça con zarzamoras, frambuesas y arándanos frescos macerados con azúcar. Servida con hielo frappé y romero infusionado en la mezcla para aportar un perfil aromático profundo y fresco.",
            imagen: basePath + "/img/bebidas/caipirinha_romero.webp"
        },
        9: {
            texto: "Ron blanco mezclado con jugo de limón natural y jarabe simple, agitado con hielo hasta alcanzar una textura tersa. Servido en copa fría con rodaja de limón y toque de ralladura cítrica para acentuar su frescura.",
            imagen: basePath + "/img/bebidas/daiquir_rodaja.webp"
        },
        10: {
            texto: "Variante frutal del clásico daiquirí, elaborado con ron blanco, jugo fresco de toronja rosada y un toque de miel silvestre orgánica. Batido con hielo y servido con una media rodaja de toronja caramelizada.",
            imagen: basePath + "/img/bebidas/daiquiri.webp"
        },
        11: {
            texto: "Tequila blanco y licor de naranja, agitados con jugo de media lima fresca y jarabe de agave. Servida en copa escarchada con sal volcánica ahumada, que realza el contraste ácido y dulce del trago.",
            imagen: basePath + "/img/bebidas/media_lima.webp"
        },
        12: {
            texto: "Ron blanco mezclado con puré artesanal de frambuesa fresca, servido sobre hielo picado en copa escarchada con azúcar de flor de hibisco deshidratada. Perfume frutal, color vibrante y sabor envolvente.",
            imagen: basePath + "/img/bebidas/vegano.webp"
        },
    };

    const descripcionEl = document.getElementById("descripcion-platillo");
    const imagenEl = document.getElementById("imagen-platillo");

    if (id && descripciones[id]) {
        descripcionEl.textContent = descripciones[id].texto;
        imagenEl.src = descripciones[id].imagen;
    } else {
        descripcionEl.textContent = "No se encontró información del platillo.";
        imagenEl.src = `${basePath}/img/error.jpg`;
    }
});