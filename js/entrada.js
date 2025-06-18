document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  const basePath = "/" + window.location.pathname.split("/")[1];

  // Diccionario de descripciones según el ID
  const descripciones = {
    1: {
      texto:
        "Mai Tai (Caribeño / Polinesio)",
      imagen: basePath + "/img/bebidas/mai-tai.webp",
      html: `<ul>
            <li>Mezcla todos los ingredientes en una coctelera con hielo.</li>
            <li>Agita bien y vierte en un vaso old fashioned con hielo.</li>
            <li>Decora con una rodaja de lima y una ramita de menta.</li>
            </ul>
            <h2>Información nutrimental</h2>
            `,
      htmlNutrim: `
            <ul>
            <li>% Alcohol: ~15-20%</li>
            <li>Calorías: ~250-300 kcal</li>
            </ul>
            `,
    },
    2: {
      texto:
        "Singapore Sling (Oriental / Exótico)",
      imagen: basePath + "/img/bebidas/singapore.webp",
      html: `
            <ul>
        <li>Mezcla todos los ingredientes (excepto la soda) en una coctelera con hielo.</li>
        <li>Agita y sirve en un vaso alto con hielo.</li>
        <li>Completa con soda y decora con una rodaja de piña y cereza.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~12-15%</li>
        <li>Calorías: ~280-350 kcal</li>
      </ul>`,
    },
    3: {
      texto:
        "Painkiller (Caribeño)",
      imagen: basePath + "/img/bebidas/painkiller.webp",
      html: `<ul>
        <li>Mezcla todos los ingredientes en una licuadora con hielo.</li>
        <li>Sirve en un vaso alto y espolvorea nuez moscada.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~15-18%</li>
        <li>Calorías: ~350-400 kcal</li>
      </ul>`,
    },
    4: {
      texto:
        "Lychee Martini.",
      imagen: basePath + "/img/bebidas/Lychee.webp",
      html: `<ul>
        <li>Agita todos los ingredientes en una coctelera con hielo.</li>
        <li>Cuela en una copa de martini fría.</li>
        <li>Decora con un lichi.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~20-25%</li>
        <li>Calorías: ~200-250 kcal</li>
      </ul>`,
    },
    5: {
      texto:
        "Zombie.",
      imagen: basePath + "/img/bebidas/zombie.webp",
      html: `<ul>
        <li>Mezcla todos los ingredientes en una coctelera con hielo.</li>
        <li>Sirve en un vaso alto con hielo y decora con frutas tropicales.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~20-25% (¡Peligrosamente fuerte!)</li>
        <li>Calorías: ~300-400 kcal</li>
      </ul>`,
    },
    6: {
      texto:
        "Sake Mojito.",
      imagen: basePath + "/img/bebidas/zake_mojito.webp",
      html: `<ul>
        <li>Mezcla todos los ingredientes en una coctelera con hielo.</li>
        <li>Sirve en un vaso alto con hielo y decora con frutas tropicales.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~20-25% (¡Peligrosamente fuerte!)</li>
        <li>Calorías: ~300-400 kcal</li>
      </ul>`,
    },
    7: {
      texto:
        "Cachaça mezclada con jugo natural de naranja, azúcar y rodajas de naranja maceradas. Agitada con hielo y servida con ramita de romero fresco flameado, que libera un perfume herbal intenso al momento de servir.",
      imagen: basePath + "/img/bebidas/caipirinha_rodajas.webp",
      html: `<ul>
        <li>Machaca la menta con el jarabe y el jugo de lima en un vaso.</li>
        <li>Agrega hielo, sake y completa con soda.</li>
        <li>Revuelve suavemente y decora con menta.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~10-12%</li>
        <li>Calorías: ~150-200 kcal</li>
      </ul>`,
    },

    8: {
      texto:
        "Cachaça mezclada con jugo natural de naranja, azúcar y rodajas de naranja maceradas. Agitada con hielo y servida con ramita de romero fresco flameado, que libera un perfume herbal intenso al momento de servir.",
      imagen: basePath + "/img/bebidas/caipirinha_rodajas.webp",
      html: `<ul>
        <li>Cachaça mezclada con jugo natural de naranja, azúcar y rodajas de naranja maceradas.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~15-18%</li>
        <li>Calorías: ~220-280 kcal</li>
      </ul>`,
    },
    9: {
      texto:
        "Combinación de cachaça con zarzamoras, frambuesas y arándanos frescos macerados con azúcar. Servida con hielo frappé y romero infusionado en la mezcla para aportar un perfil aromático profundo y fresco.",
      imagen: basePath + "/img/bebidas/caipirinha_romero.webp",
      html: `<ul>
        <li>Combinación de cachaça con zarzamoras, frambuesas y arándanos frescos macerados con azúcar.</li>
        <li>Servida con hielo frappé y romero infusionado.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~14-16%</li>
        <li>Calorías: ~250-320 kcal</li>
        <li>Aromas: Perfil profundo y fresco (romero + frutos rojos)</li>
      </ul>`,
    },
    10: {
      texto:
        "Ron blanco mezclado con jugo de limón natural y jarabe simple, agitado con hielo hasta alcanzar una textura tersa. Servido en copa fría con rodaja de limón y toque de ralladura cítrica para acentuar su frescura.",
      imagen: basePath + "/img/bebidas/daiquir_rodaja.webp",
      html: `<ul>
        <li>Ron blanco mezclado con jugo de limón natural y jarabe simple.</li>
        <li>Agitado con hielo hasta textura tersa.</li>
        <li>Servido en copa fría con rodaja de limón y ralladura cítrica.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~20-22%</li>
        <li>Calorías: ~180-220 kcal</li>
        <li>Nota: Frescura cítrica acentuada</li>
      </ul>`,
    },
    11: {
      texto:
        "Variante frutal del clásico daiquirí, elaborado con ron blanco, jugo fresco de toronja rosada y un toque de miel silvestre orgánica. Batido con hielo y servido con una media rodaja de toronja caramelizada.",
      imagen: basePath + "/img/bebidas/daiquiri.webp",
      html: `<ul>
        <li>Ron blanco, jugo fresco de toronja rosada y miel silvestre orgánica.</li>
        <li>Batido con hielo.</li>
        <li>Servido con media rodaja de toronja caramelizada.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~18-20%</li>
        <li>Calorías: ~240-300 kcal</li>
        <li>Variante: Daiquirí frutal</li>
      </ul>`,
    },
    12: {
      texto:
        "Tequila blanco y licor de naranja, agitados con jugo de media lima fresca y jarabe de agave. Servida en copa escarchada con sal volcánica ahumada, que realza el contraste ácido y dulce del trago.",
      imagen: basePath + "/img/bebidas/media_lima.webp",
      html: `<ul>
        <li>Tequila blanco y licor de naranja, agitados con jugo de lima y jarabe de agave.</li>
        <li>Servido en copa escarchada con sal volcánica ahumada.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~25-28%</li>
        <li>Calorías: ~280-350 kcal</li>
        <li>Contraste: Ácido-dulce con sal ahumada</li>
      </ul>`,
    },
    13: {
      texto:
        "Ron blanco mezclado con puré artesanal de frambuesa fresca, servido sobre hielo picado en copa escarchada con azúcar de flor de hibisco deshidratada. Perfume frutal, color vibrante y sabor envolvente.",
      imagen: basePath + "/img/bebidas/vegano.webp",
      html: `<ul>
        <li>Ron blanco con puré artesanal de frambuesa fresca.</li>
        <li>Servido sobre hielo picado en copa escarchada con azúcar de flor de hibisco.</li>
      </ul>
      <h2>Información nutrimental</h2>`,
      htmlNutrim: `<ul>
        <li>% Alcohol: ~16-18%</li>
        <li>Calorías: ~260-330 kcal</li>
        <li>Características: Color vibrante, perfume frutal</li>
      </ul>`,
    },
  };

  const descripcionEl = document.getElementById("descripcion-platillo");
  const imagenEl = document.getElementById("imagen-platillo");
  const html = document.getElementById("html");
  const htmlNutrimental = document.getElementById("html-nutrimental");

  if (id && descripciones[id]) {
    descripcionEl.textContent = descripciones[id].texto;
    imagenEl.src = descripciones[id].imagen;
    html.innerHTML = descripciones[id].html;
    htmlNutrimental.innerHTML = descripciones[id].htmlNutrim;
  } else {
    descripcionEl.textContent = "No se encontró información del platillo.";
    imagenEl.src = `${basePath}/img/error.jpg`;
  }
});
