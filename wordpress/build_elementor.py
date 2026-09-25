"""Genera la estructura de Elementor (containers + widgets nativos) de cada página de Karu Esencial.

Salida: wordpress/elementor/<pagina>.json, listo para guardarse como _elementor_data.
Solo usa widgets clásicos de Elementor Free: heading, text-editor, button, image,
icon-list, icon-box, icon y nested-accordion, más el widget de WPForms en Contacto.
"""
import json
import random
from pathlib import Path
from urllib.parse import quote

random.seed(20260925)
SITE = "https://www.karuesencial.cl"
WA = "https://wa.me/56989048914"

IMG = {
    "hero": (62, "hero-composicion.svg"),
    "vinagre": (63, "producto-vinagre.svg"),
    "percarbonato": (64, "producto-percarbonato.svg"),
    "bicarbonato": (65, "producto-bicarbonato.svg"),
    "aceite": (66, "proximamente-aceite.svg"),
    "cafe": (67, "proximamente-cafe.svg"),
}

_used = set()


def eid():
    while True:
        v = "%07x" % random.getrandbits(28)
        if v not in _used:
            _used.add(v)
            return v


def wa(msg=None):
    return WA if not msg else f"{WA}?text={quote(msg)}"


def px(v):
    return {"unit": "px", "size": v, "sizes": []}


def pct(v):
    return {"unit": "%", "size": v, "sizes": []}


def dims(t, r=None, b=None, l=None, unit="px"):
    r = t if r is None else r
    b = t if b is None else b
    l = r if l is None else l
    return {"unit": unit, "top": str(t), "right": str(r), "bottom": str(b), "left": str(l),
            "isLinked": t == r == b == l}


def gap(v):
    return {"column": str(v), "row": str(v), "isLinked": True, "unit": "px", "size": v}


def gc(cid):
    return f"globals/colors?id={cid}"


def gt(tid):
    return f"globals/typography?id={tid}"


def link(url, external=None):
    ext = url.startswith("http") and not url.startswith(SITE) if external is None else external
    return {"url": url, "is_external": "on" if ext else "", "nofollow": "", "custom_attributes": ""}


def icon(value, lib=None):
    if lib is None:
        lib = "fa-brands" if value.startswith("fab") else "fa-solid"
    return {"value": value, "library": lib}


def shadow(y=14, blur=36, alpha=0.09, spread=0):
    return {"horizontal": 0, "vertical": y, "blur": blur, "spread": spread,
            "color": f"rgba(36,61,91,{alpha})"}


# ---------------------------------------------------------------- primitivas

def container(children, inner=True, **s):
    return {"id": eid(), "elType": "container", "isInner": inner, "settings": s, "elements": children}


def widget(kind, **s):
    return {"id": eid(), "elType": "widget", "widgetType": kind, "settings": s, "elements": []}


def section(children, *, bg=None, pad=(120, 120), pad_m=(64, 64), anchor=None, title=None, **extra):
    s = {
        "content_width": "boxed",
        "flex_direction": "column",
        "flex_gap": gap(0),
        "padding": dims(pad[0], 20, pad[1], 20),
        "padding_mobile": dims(pad_m[0], 18, pad_m[1], 18),
        "html_tag": "section",
    }
    if bg:
        s["background_background"] = "classic"
        s["__globals__"] = {"background_color": gc(bg)}
    if anchor:
        s["_element_id"] = anchor
    if title:
        s["_title"] = title
    s.update(extra)
    return container(children, inner=False, **s)


def column(children, width=None, width_t=None, width_m=100, g=24, align=None, **s):
    base = {"content_width": "full", "flex_direction": "column", "flex_gap": gap(g)}
    if width is not None:
        base["width"] = pct(width)
        base["width_tablet"] = pct(width_t if width_t is not None else width)
        base["width_mobile"] = pct(width_m)
    if align:
        base["flex_align_items"] = align
    base.update(s)
    return container(children, **base)


def row(children, g=24, align="center", wrap=False, stack="mobile", **s):
    base = {"content_width": "full", "flex_direction": "row", "flex_gap": gap(g), "flex_align_items": align}
    if wrap:
        base["flex_wrap"] = "wrap"
    if stack == "tablet":
        base["flex_direction_tablet"] = "column"
        base["flex_align_items_tablet"] = "stretch"
    if stack in ("mobile", "tablet"):
        base["flex_direction_mobile"] = "column"
        base["flex_align_items_mobile"] = "stretch"
    base.update(s)
    return container(children, **base)


def grid(children, cols, cols_t=2, cols_m=1, g=24, **s):
    base = {
        "content_width": "full",
        "container_type": "grid",
        "grid_columns_grid": {"unit": "fr", "size": cols, "sizes": []},
        "grid_columns_grid_tablet": {"unit": "fr", "size": cols_t, "sizes": []},
        "grid_columns_grid_mobile": {"unit": "fr", "size": cols_m, "sizes": []},
        "grid_rows_grid": {"unit": "fr", "size": 1, "sizes": []},
        "grid_rows_grid_tablet": {"unit": "fr", "size": -(-len(children) // cols_t), "sizes": []},
        "grid_rows_grid_mobile": {"unit": "fr", "size": -(-len(children) // cols_m), "sizes": []},
        "grid_gaps": {"column": str(g), "row": str(g), "isLinked": True, "unit": "px"},
        "grid_auto_flow": "row",
        "grid_align_items": "stretch",
    }
    base.update(s)
    return container(children, **base)


def heading(text, tag="h2", typo=None, color="accent", align=None, align_m=None, **s):
    d = {"title": text, "header_size": tag}
    g = {}
    if typo:
        g["typography_typography"] = gt(typo)
    if color:
        g["title_color"] = gc(color)
    if g:
        d["__globals__"] = g
    if align:
        d["align"] = align
    if align_m:
        d["align_mobile"] = align_m
    d.update(s)
    return widget("heading", **d)


def eyebrow(text, align=None):
    return heading(text, "p", "eyebrow", "primary", align)


def text(html, typo="text", color="text", align=None, **s):
    d = {"editor": html, "__globals__": {"typography_typography": gt(typo), "text_color": gc(color)}}
    if align:
        d["align"] = align
    d.update(s)
    return widget("text-editor", **d)


def button(label, url, kind="primary", size="md", ico="fab fa-whatsapp", ico_after=False, full=False,
           align=None, align_m=None, **s):
    d = {
        "text": label,
        "link": link(url),
        "size": size,
        "border_radius": dims(999),
        "button_hover_transition_duration": {"unit": "s", "size": 0.2, "sizes": []},
        "__globals__": {"typography_typography": gt("accent")},
    }
    if ico:
        d["selected_icon"] = icon(ico)
        d["icon_indent"] = px(10)
        if ico_after:
            d["icon_align"] = "row-reverse"
    pads = {"md": dims(15, 28), "lg": dims(18, 32), "xl": dims(22, 40), "sm": dims(11, 20)}
    d["text_padding"] = pads.get(size, dims(15, 28))
    if kind == "primary":
        d["__globals__"].update({"background_color": gc("primary"), "button_text_color": gc("blanco"),
                                 "button_background_hover_color": gc("azulhover"), "hover_color": gc("blanco")})
        d["button_box_shadow_box_shadow_type"] = "yes"
        d["button_box_shadow_box_shadow"] = {"horizontal": 0, "vertical": 6, "blur": 18, "spread": 0,
                                             "color": "rgba(74,144,226,0.28)"}
    elif kind == "ghost":
        d.update({"border_border": "solid", "border_width": dims(2)})
        d["__globals__"].update({"background_color": gc("blanco"), "button_text_color": gc("accent"),
                                 "border_color": gc("grisclaro"), "button_background_hover_color": gc("celestesuave"),
                                 "hover_color": gc("accent"), "button_hover_border_color": gc("secondary")})
    elif kind == "white":
        d["__globals__"].update({"background_color": gc("blanco"), "button_text_color": gc("accent"),
                                 "button_background_hover_color": gc("blancocalido"), "hover_color": gc("accent")})
        d["button_box_shadow_box_shadow_type"] = "yes"
        d["button_box_shadow_box_shadow"] = {"horizontal": 0, "vertical": 10, "blur": 30, "spread": 0,
                                             "color": "rgba(20,50,90,0.18)"}
    elif kind == "link":
        d["text_padding"] = dims(0)
        d["background_background"] = "classic"
        d["background_color"] = "rgba(255,255,255,0)"
        d["button_background_hover_color"] = "rgba(255,255,255,0)"
        d["__globals__"].update({"button_text_color": gc("primary"), "hover_color": gc("azulhover")})
    if full:
        d["align"] = "justify"
    if align:
        d["align"] = align
    if align_m:
        d["align_mobile"] = align_m
    d.update(s)
    return widget("button", **d)


def image(key, height=None, height_m=None, radius=None, **s):
    iid, fname = IMG[key]
    d = {
        "image": {"url": f"{SITE}/wp-content/uploads/2026/09/{fname}", "id": iid, "size": "", "source": "library"},
        "image_size": "full",
        "width": pct(100),
    }
    if height:
        d["height"] = px(height)
        d["object-fit"] = "cover"
        if height_m:
            d["height_mobile"] = px(height_m)
    if radius is not None:
        d["image_border_radius"] = dims(radius)
    d.update(s)
    return widget("image", **d)


def checklist(items, inline=False, size=14, color="text", **s):
    d = {
        "view": "inline" if inline else "traditional",
        "icon_list": [{"_id": eid(), "text": t, "selected_icon": icon("fas fa-check")} for t in items],
        "icon_size": px(size),
        "space_between": px(10 if not inline else 22),
        "text_indent": px(8),
        "__globals__": {"icon_color": gc("primary"), "text_color": gc(color), "icon_typography_typography": gt("pequeno")},
    }
    d.update(s)
    return widget("icon-list", **d)


def card(children, pad=0, g=0, hover=True, **s):
    d = {
        "content_width": "full",
        "flex_direction": "column",
        "flex_gap": gap(g),
        "padding": dims(pad),
        "background_background": "classic",
        "border_border": "solid",
        "border_width": dims(1),
        "border_radius": dims(20),
        "overflow": "hidden",
        "box_shadow_box_shadow_type": "yes",
        "box_shadow_box_shadow": shadow(4, 16, 0.05),
        "__globals__": {"background_color": gc("blanco"), "border_color": gc("grisclaro")},
    }
    if hover:
        d.update({
            "box_shadow_hover_box_shadow_type": "yes",
            "box_shadow_hover_box_shadow": shadow(14, 36, 0.10),
            "_transform_translateY_effect_hover": px(-4),
            "_transform_transition_hover": {"unit": "px", "size": 250, "sizes": []},
        })
    d.update(s)
    return container(children, **d)


def section_head(eyebrow_text, title, body=None, align="center", tag="h2"):
    items = []
    if eyebrow_text:
        items.append(eyebrow(eyebrow_text, align))
    items.append(heading(title, tag, "h2seccion", "accent", align))
    if body:
        items.append(text(f"<p>{body}</p>", align=align))
    return container(items, content_width="boxed", boxed_width=px(680), flex_direction="column",
                     flex_gap=gap(14), flex_align_items="center" if align == "center" else "flex-start",
                     padding=dims(0, 0, 56, 0), padding_mobile=dims(0, 0, 36, 0), _title="Encabezado de sección")


# ---------------------------------------------------------------- secciones

def hero():
    left = column([
        eyebrow("Esenciales para el hogar · Chile"),
        heading('Lo esencial para un hogar <span style="color:#4A90E2">más simple.</span>', "h1", "h1hero"),
        text("<p>Vinagre incoloro, percarbonato de sodio y bicarbonato de sodio: tres básicos versátiles "
             "para limpiar y cuidar tu casa. Elige lo que necesitas y pídelo directo por WhatsApp.</p>", typo="lead"),
        row([
            button("Pedir por WhatsApp", wa("Hola Karu Esencial, quiero hacer un pedido."), size="lg"),
            button("Conocer productos", f"{SITE}/productos/", kind="ghost", size="lg",
                   ico="fas fa-arrow-right", ico_after=True),
        ], g=12, wrap=True, stack=None, _title="Botones", flex_direction_mobile="column",
            flex_align_items_mobile="stretch"),
        checklist(["Pedidos directos por WhatsApp", "Atención cercana", "Productos multiuso"], inline=True,
                  size=13, _margin=dims(4, 0, 0, 0)),
    ], width=52, width_t=100, g=24, _title="Texto hero")
    note = row([
        widget("icon", selected_icon=icon("fas fa-comment"), view="stacked", shape="rounded",
               size=px(18), icon_padding=px(11), border_radius=dims(12),
               __globals__={"primary_color": gc("celestesuave"), "secondary_color": gc("primary")}),
        text("<p><strong>¿Dudas?</strong> Escríbenos al<br>+56 9 8904 8914</p>", typo="pequeno"),
    ], g=12, stack=None, _title="Nota flotante", width={"unit": "px", "size": 250, "sizes": []},
        padding=dims(14, 18), background_background="classic", border_radius=dims(18),
        box_shadow_box_shadow_type="yes", box_shadow_box_shadow=shadow(14, 36, 0.12),
        position="absolute", _offset_orientation_h="start", _offset_x=px(-24),
        _offset_orientation_v="end", _offset_y_end=px(28), z_index=2, hide_mobile="hidden-mobile",
        __globals__={"background_color": gc("blanco")})
    right = column([
        image("hero", radius=32, image_box_shadow_box_shadow_type="yes", image_box_shadow_box_shadow=shadow(14, 36, 0.09)),
        note,
    ], width=48, width_t=100, g=0, _title="Imagen hero")
    return section([row([left, right], g=64, stack="tablet", _title="Hero")],
                   pad=(64, 72), pad_m=(28, 48), title="Hero", anchor="inicio")


PRODUCTS = [
    ("vinagre", "Cocina y baño", "Vinagre Incoloro",
     "Un clásico de la casa que acompaña la limpieza de todos los días.",
     ["Vidrios, espejos y cerámicas", "Ayuda a remover sarro en hervidores y llaves", "Superficies de cocina y baño"]),
    ("percarbonato", "Lavado de ropa", "Percarbonato de Sodio",
     "Gránulos que liberan oxígeno al disolverse en agua tibia o caliente. Muy usado en el lavado y la limpieza.",
     ["Complemento para lavar ropa blanca", "Remojo de prendas con manchas", "Juntas, tablas y superficies"]),
    ("bicarbonato", "Multiuso", "Bicarbonato de Sodio",
     "El comodín de la casa: un polvo suave que sirve para muchas tareas de limpieza.",
     ["Limpieza suave de ollas, lavaplatos y horno", "Ayuda a reducir olores en refrigerador y calzado",
      "Complemento en el lavado de ropa"]),
]


def tag(label):
    return heading(label, "p", "pequeno", "primary",
                   _background_background="classic", _padding=dims(4, 12), _border_radius=dims(999),
                   _element_width="auto", _flex_align_self="flex-start",
                   typography_typography="custom", typography_font_size=px(13), typography_font_weight="700",
                   __globals__={"title_color": gc("primary"), "_background_color": gc("celestesuave")})


def product_card(key, tg, name, desc, uses):
    body = column([
        column([
            tag(tg),
            heading(name, "h3", "h3tarjeta"),
            text(f"<p>{desc}</p>"),
            heading("Usos habituales", "p", "eyebrow", "text", _margin=dims(4, 0, 0, 0),
                    typography_typography="custom", typography_font_size=px(12)),
            checklist(uses, size=12, _margin=dims(0, 0, 8, 0)),
        ], g=12, _flex_size="grow", _title="Contenido"),
        button("Consultar por WhatsApp", wa(f"Hola Karu Esencial, quiero consultar por el {name}."), full=True),
    ], g=16, _flex_size="grow", padding=dims(26, 26, 28, 26), _title="Cuerpo")
    return card([image(key, height=300, height_m=260), body], _title=name,
                animation="fadeInUp", animation_duration="fast")


def products_grid():
    return grid([product_card(*p) for p in PRODUCTS], 3, cols_t=2, cols_m=1, g=24, _title="Tarjetas de productos")


def safety_note():
    return text("<p>Lee siempre las indicaciones del envase y no mezcles productos de limpieza con cloro.</p>",
                typo="pequeno", align="center", _margin=dims(24, 0, 0, 0))


def soon_card(key, name, desc):
    return card([
        image(key, height=200, height_m=190),
        column([
            heading("Próximamente", "p", "pequeno", "primary", _padding=dims(3, 10),
                    _border_border="dashed", _border_width=dims(1), _border_radius=dims(999),
                    _element_width="auto", _flex_align_self="flex-start",
                    typography_typography="custom", typography_font_size=px(12), typography_font_weight="700",
                    __globals__={"title_color": gc("primary"), "_border_color": gc("primary")}),
            heading(name, "h4", "h3tarjeta"),
            text(f"<p>{desc}</p>", typo="pequeno"),
            button("Avísame por WhatsApp", wa(f"Hola Karu Esencial, avísenme cuando llegue el {name}."),
                   kind="link", ico="fas fa-arrow-right", ico_after=True),
        ], g=8, padding=dims(20, 22, 22, 22), _title="Cuerpo"),
    ], hover=False, box_shadow_box_shadow_type="", _title=name)


def soon_block():
    left = column([
        eyebrow("Próximamente"),
        heading("Nuevos esenciales para tu cocina", "h3", None, "accent",
                typography_typography="custom", typography_font_family="Nunito", typography_font_weight="800",
                typography_font_size=px(30), typography_font_size_mobile=px(24),
                typography_line_height={"unit": "em", "size": 1.15, "sizes": []}),
        text("<p>Estamos preparando dos productos más. Si te interesan, escríbenos y te avisamos cuando estén disponibles.</p>"),
    ], width=32, width_t=100, g=12, _title="Texto")
    right = grid([
        soon_card("aceite", "Aceite de Oliva", "Para cocinar, aliñar y compartir en la mesa."),
        soon_card("cafe", "Café en Grano", "Para preparar en casa, a tu manera."),
    ], 2, cols_t=2, cols_m=1, g=20, width=pct(68), width_tablet=pct(100), width_mobile=pct(100), _title="Tarjetas")
    return row([left, right], g=48, stack="tablet", _title="Próximamente",
               padding=dims(48), padding_mobile=dims(28, 20), margin=dims(88, 0, 0, 0),
               margin_mobile=dims(56, 0, 0, 0), background_background="classic", border_radius=dims(32),
               __globals__={"background_color": gc("blancocalido")})


def products_section(with_head=True, soon=True):
    items = []
    if with_head:
        items.append(section_head("Productos", "Nuestros productos esenciales",
                                  "Tres básicos que resuelven muchas tareas de la casa. Te contamos para qué se usan "
                                  "y te ayudamos a elegir el formato que te acomoda."))
    items += [products_grid(), safety_note()]
    if soon:
        items.append(soon_block())
    return section(items, anchor="productos", title="Productos", pad=(120 if with_head else 88, 120))


BENEFITS = [
    ("fas fa-th-large", "Versatilidad", "Un mismo producto te acompaña en distintas tareas de la casa."),
    ("fas fa-home", "Simpleza", "Productos fáciles de entender y de sumar a tu rutina."),
    ("fas fa-coins", "Ahorro", "Básicos multiuso que pueden ayudarte a ordenar el presupuesto del hogar."),
    ("fas fa-leaf", "Conciencia", "Una propuesta pensada para un consumo más consciente."),
]


def benefit(ico, title, desc):
    return widget(
        "icon-box",
        selected_icon=icon(ico), view="stacked", shape="rounded", title_text=title, description_text=desc,
        title_size="h3", position="block-start", position_mobile="inline-start", text_align="start",
        icon_size=px(26), icon_padding=px(15), border_radius=dims(18), icon_space=px(18),
        title_bottom_space=px(10),
        title_typography_typography="custom", title_typography_font_family="Nunito",
        title_typography_font_weight="800", title_typography_font_size=px(20),
        description_typography_typography="custom", description_typography_font_size=px(15.5),
        description_typography_line_height={"unit": "em", "size": 1.6, "sizes": []},
        _background_background="classic", _padding=dims(30, 26), _padding_mobile=dims(22, 20),
        _border_radius=dims(20), _animation="fadeInUp", animation_duration="fast",
        __globals__={"primary_color": gc("secondary"), "secondary_color": gc("accent"),
                     "title_color": gc("accent"), "description_color": gc("text"),
                     "_background_color": gc("blanco")},
    )


def benefits_section(with_head=True, tag_title="h2"):
    items = []
    if with_head:
        items.append(section_head("Beneficios", "¿Por qué elegir Karu Esencial?",
                                  "Pocos productos, bien elegidos, para las tareas de todos los días.", tag=tag_title))
    items.append(grid([benefit(*b) for b in BENEFITS], 4, cols_t=2, cols_m=1, g=20, _title="Beneficios"))
    return section(items, bg="celestesuave", anchor="beneficios", title="Beneficios")


STEPS = [
    ("01", "Elige", "Conoce nuestros productos y elige lo que necesitas."),
    ("02", "Escríbenos", "Haz clic en WhatsApp y cuéntanos qué productos buscas."),
    ("03", "Coordina tu pedido", "Te ayudamos a coordinar tu compra y la entrega."),
]


def step(num, title, desc, last=False):
    s = {}
    if not last:
        s.update({"border_border": "solid", "border_width": dims(0, 0, 1, 0),
                  "__globals__": {"border_color": gc("grisclaro")}})
    return row([
        heading(num, "p", "numero", "secondary", _element_width="initial",
                _element_custom_width=px(64), _element_custom_width_mobile=px(48),
                text_stroke_text_stroke_type="yes", text_stroke_text_stroke=px(1.5),
                text_stroke_stroke_color="#4A90E2"),
        column([heading(title, "h3", None, "accent", typography_typography="custom",
                        typography_font_family="Nunito", typography_font_weight="800",
                        typography_font_size=px(20)),
                text(f"<p>{desc}</p>")], g=4, _flex_size="grow"),
    ], g=18, align="flex-start", stack=None, padding=dims(18, 0), _title=f"Paso {num}", **s)


def chat_card():
    top = row([
        widget("icon", selected_icon=icon("fab fa-whatsapp"), view="stacked", shape="circle", size=px(20),
               icon_padding=px(11), __globals__={"primary_color": gc("whatsapp"), "secondary_color": gc("blanco")}),
        column([
            heading("Karu Esencial", "p", None, "accent", typography_typography="custom",
                    typography_font_family="Figtree", typography_font_weight="700", typography_font_size=px(16)),
            heading("+56 9 8904 8914", "p", "pequeno", "text", typography_typography="custom",
                    typography_font_size=px(13)),
        ], g=0),
    ], g=12, stack=None, padding=dims(12, 14, 16, 14), _title="Contacto")
    body = column([
        text("<p>Hola Karu Esencial, quiero pedir bicarbonato de sodio y vinagre incoloro. ¿Qué formatos tienen?</p>",
             typo="pequeno", color="accent", _background_background="classic", _padding=dims(14, 16),
             _border_radius={"unit": "px", "top": "18", "right": "18", "bottom": "4", "left": "18", "isLinked": False},
             _element_width="initial", _element_custom_width=pct(88), _flex_align_self="flex-end",
             __globals__={"typography_typography": gt("pequeno"), "text_color": gc("accent"),
                          "_background_color": gc("secondary")}),
        text("<p>Así de simple: un mensaje y coordinamos tu pedido por el mismo chat.</p>", typo="pequeno",
             align="center", typography_typography="custom", typography_font_size=px(14)),
    ], g=18, padding=dims(28, 22, 24, 22), background_background="classic", border_radius=dims(22),
        __globals__={"background_color": gc("blanco")}, _title="Mensaje")
    return column([top, body], width=45, width_t=100, g=0, padding=dims(14), background_background="classic",
                  border_radius=dims(32), box_shadow_box_shadow_type="yes", box_shadow_box_shadow=shadow(4, 16, 0.05),
                  hide_mobile="hidden-mobile", _title="Ejemplo de chat",
                  __globals__={"background_color": gc("celestesuave")})


def how_to_buy_section():
    left = column([
        eyebrow("Cómo comprar"),
        heading("Comprar es simple", "h2", "h2seccion"),
        column([step(*s, last=i == len(STEPS) - 1) for i, s in enumerate(STEPS)], g=0, _title="Pasos"),
        button("Quiero comprar", wa("Hola Karu Esencial, quiero comprar."), size="lg", align_m="justify"),
    ], width=55, width_t=100, g=24, _title="Pasos para comprar")
    return section([row([left, chat_card()], g=88, stack="tablet", _title="Cómo comprar")],
                   anchor="como-comprar", title="Cómo comprar")


def testimonial_slot(hide_m=False):
    s = {"hide_mobile": "hidden-mobile"} if hide_m else {}
    return container([
        widget("icon", selected_icon=icon("fas fa-quote-left"), size=px(28), align="start",
               __globals__={"primary_color": gc("secondary")}),
        text("<p>Aquí publicaremos la opinión de un cliente real, con su autorización.</p>"),
        heading("Espacio para testimonio", "p", "pequeno", "text", typography_typography="custom",
                typography_font_weight="700", typography_font_size=px(14)),
    ], content_width="full", flex_direction="column", flex_gap=gap(14), padding=dims(28),
        border_border="dashed", border_width=dims(2), border_color="#CBD9E8", border_radius=dims(20),
        background_background="classic", _title="Espacio para testimonio",
        __globals__={"background_color": gc("blanco")}, **s)


def testimonials_section():
    return section([
        section_head("Testimonios", "Experiencias de nuestros clientes",
                     "Pronto compartiremos aquí las opiniones de quienes ya usan Karu Esencial. "
                     "Solo publicamos testimonios reales y con autorización."),
        grid([testimonial_slot(), testimonial_slot(True), testimonial_slot(True)], 3, cols_t=3, cols_m=1, g=20,
             _title="Testimonios"),
        button("¿Ya compraste? Cuéntanos tu experiencia",
               wa("Hola Karu Esencial, quiero compartir mi experiencia con sus productos."),
               kind="link", ico="fas fa-arrow-right", ico_after=True, align="center", _margin=dims(32, 0, 0, 0)),
    ], bg="blancocalido", anchor="testimonios", title="Testimonios")


FAQ = [
    ("¿Cómo puedo comprar?",
     "Escríbenos por WhatsApp al +56 9 8904 8914 con los productos que te interesan. Coordinamos tu pedido por el mismo chat."),
    ("¿Dónde realizan entregas?",
     "Cuéntanos tu comuna por WhatsApp y te confirmamos las opciones de entrega disponibles para tu zona."),
    ("¿Cómo puedo conocer los precios?",
     "Te compartimos precios y formatos actualizados por WhatsApp, según los productos que necesites."),
    ("¿Qué usos tiene cada producto?",
     f'En la página de <a href="{SITE}/productos/">Productos</a> encontrarás los usos habituales de cada uno. '
     "Si tienes una duda puntual, escríbenos y te orientamos. Lee siempre las indicaciones del envase."),
    ("¿Qué formatos están disponibles?",
     "Los formatos pueden variar según disponibilidad. Consúltanos por WhatsApp y te contamos las opciones vigentes."),
    ("¿Cómo puedo contactar a Karu Esencial?",
     f'Nuestro canal principal es WhatsApp: +56 9 8904 8914. También puedes llamarnos a ese número o '
     f'escribirnos desde la página de <a href="{SITE}/contacto/">Contacto</a>.'),
]


def accordion(items):
    w = widget(
        "nested-accordion",
        items=[{"_id": eid(), "item_title": q, "element_css_id": ""} for q, _ in items],
        title_tag="h3", default_state="expanded", max_items_expended="one", faq_schema="yes",
        accordion_item_title_icon=icon("fas fa-plus"), accordion_item_title_icon_active=icon("fas fa-minus"),
        accordion_item_title_icon_position="end",
        accordion_item_title_space_between=px(12), accordion_item_title_distance_from_content=px(0),
        accordion_background_normal_background="classic", accordion_background_hover_background="classic",
        accordion_background_active_background="classic",
        accordion_border_normal_border="solid", accordion_border_normal_width=dims(1),
        accordion_border_hover_border="solid", accordion_border_hover_width=dims(1),
        accordion_border_active_border="solid", accordion_border_active_width=dims(1),
        accordion_border_radius=dims(16), accordion_padding=dims(18, 22),
        title_typography_typography="custom", title_typography_font_family="Nunito",
        title_typography_font_weight="800", title_typography_font_size=px(17),
        icon_size=px(14), icon_spacing=px(16),
        content_padding=dims(0), content_border_border="none",
        __globals__={
            "accordion_background_normal_color": gc("blanco"), "accordion_background_hover_color": gc("celestesuave"),
            "accordion_background_active_color": gc("celestesuave"),
            "accordion_border_normal_color": gc("grisclaro"), "accordion_border_hover_color": gc("secondary"),
            "accordion_border_active_color": gc("secondary"),
            "normal_title_color": gc("accent"), "hover_title_color": gc("accent"), "active_title_color": gc("accent"),
            "normal_icon_color": gc("primary"), "hover_icon_color": gc("primary"), "active_icon_color": gc("primary"),
        },
    )
    for q, a in items:
        w["elements"].append(container([text(f"<p>{a}</p>")], content_width="full", flex_direction="column",
                                       padding=dims(14, 22, 18, 22), _title=q))
    return w


def faq_section(items, more_link=False, tag_title="h2"):
    head_items = [
        eyebrow("Preguntas frecuentes"),
        heading("Resolvemos tus dudas", tag_title, "h2seccion"),
        text("<p>¿No encuentras lo que buscas? Escríbenos y te respondemos por WhatsApp.</p>"),
        button("Consultar por WhatsApp", wa("Hola Karu Esencial, tengo una consulta."), kind="ghost",
               _margin=dims(8, 0, 0, 0)),
    ]
    right = [accordion(items)]
    if more_link:
        right.append(button("Ver todas las preguntas", f"{SITE}/preguntas-frecuentes/", kind="link",
                            ico="fas fa-arrow-right", ico_after=True, _margin=dims(12, 0, 0, 0)))
    return section([row([
        column(head_items, width=38, width_t=100, g=14, _title="Encabezado"),
        column(right, width=62, width_t=100, g=8, _title="Preguntas"),
    ], g=88, align="flex-start", stack="tablet", _title="Preguntas frecuentes")],
        anchor="preguntas", title="Preguntas frecuentes")


def cta_section():
    panel = container([
        heading("¿Qué necesitas para tu hogar?", "h2", None, "blanco", "center",
                typography_typography="custom", typography_font_family="Nunito", typography_font_weight="900",
                typography_font_size=px(54), typography_font_size_tablet=px(44), typography_font_size_mobile=px(34),
                typography_line_height={"unit": "em", "size": 1.1, "sizes": []},
                typography_letter_spacing=px(-1)),
        text("<p>Conoce nuestros productos y haz tu pedido directamente por WhatsApp.</p>", typo="lead",
             color="blanco", align="center", _element_width="initial", _element_custom_width={"unit": "px", "size": 520, "sizes": []},
             _element_custom_width_mobile=pct(100)),
        button("Pedir por WhatsApp", WA, kind="white", size="xl", align="center", align_m="justify",
               _margin=dims(10, 0, 0, 0)),
        heading("+56 9 8904 8914", "p", "pequeno", "secondary", "center", typography_typography="custom",
                typography_font_weight="600", typography_letter_spacing=px(0.6)),
    ], content_width="full", flex_direction="column", flex_align_items="center", flex_gap=gap(18),
        padding=dims(96, 64), padding_mobile=dims(56, 22), border_radius=dims(32),
        background_background="gradient", background_color="#6AA8EE", background_color_b="#4A90E2",
        background_color_stop=pct(0), background_color_b_stop=pct(55),
        background_gradient_type="radial", background_gradient_position="top left",
        _title="Panel CTA")
    return section([panel], pad=(0, 120), pad_m=(0, 64), title="CTA final")


def page_intro(eyebrow_text, title, body):
    return section([container([
        eyebrow(eyebrow_text, "center"),
        heading(title, "h1", "h2seccion", "accent", "center"),
        text(f"<p>{body}</p>", typo="lead", align="center"),
    ], content_width="boxed", boxed_width=px(720), flex_direction="column", flex_align_items="center",
        flex_gap=gap(16), _title="Encabezado de página")], bg="celestesuave", pad=(88, 80), pad_m=(48, 44),
        title="Encabezado de página")


def contact_card(ico, small, big, url=None, main=False):
    ic = widget("icon", selected_icon=icon(ico), view="stacked", shape="circle" if main else "rounded",
                size=px(26 if main else 20), icon_padding=px(15 if main else 14), border_radius=dims(14),
                __globals__={"primary_color": gc("whatsapp" if main else "celestesuave"),
                             "secondary_color": gc("blanco" if main else "primary")})
    txt = column([
        heading(small, "p", "pequeno", "text", typography_typography="custom", typography_font_size=px(13),
                typography_font_weight="600"),
        heading(big, "p", None, "accent", typography_typography="custom", typography_font_family="Nunito",
                typography_font_weight="900" if main else "800", typography_font_size=px(24 if main else 18),
                typography_font_size_mobile=px(21 if main else 17)),
    ], g=2, _flex_size="grow")
    kids = [ic, txt]
    if main:
        kids.append(heading("Escribir →", "p", None, "primary", typography_typography="custom",
                            typography_font_family="Figtree", typography_font_weight="700",
                            typography_font_size=px(16), hide_mobile="hidden-mobile"))
    s = dict(content_width="full", flex_direction="row", flex_align_items="center", flex_gap=gap(16),
             padding=dims(24 if main else 20), border_border="solid", border_width=dims(1), border_radius=dims(20),
             background_background="classic", box_shadow_box_shadow_type="yes", box_shadow_box_shadow=shadow(4, 16, 0.05),
             _title=small,
             __globals__={"background_color": gc("celestesuave" if main else "blanco"),
                          "border_color": gc("secondary" if main else "grisclaro")})
    if url:
        s.update({"html_tag": "a", "link": link(url), "box_shadow_hover_box_shadow_type": "yes",
                  "box_shadow_hover_box_shadow": shadow(14, 36, 0.10),
                  "_transform_translateY_effect_hover": px(-2),
                  "_transform_transition_hover": {"unit": "px", "size": 200, "sizes": []}})
    return container(kids, **s)


def contact_section(form_id):
    left = column([
        heading("Hablemos por WhatsApp", "h2", None, "accent", typography_typography="custom",
                typography_font_family="Nunito", typography_font_weight="800", typography_font_size=px(30),
                typography_font_size_mobile=px(26)),
        text("<p>Es la forma más rápida de hacer tu pedido o resolver una duda.</p>"),
        contact_card("fab fa-whatsapp", "WhatsApp · canal principal", "+56 9 8904 8914", WA, main=True),
        contact_card("fas fa-phone", "Teléfono", "+56 9 8904 8914", "tel:+56989048914"),
        contact_card("fas fa-truck", "Entregas", "Coordinamos por WhatsApp"),
    ], width=46, width_t=100, g=16, _title="Canales de contacto")
    form = column([
        heading("Déjanos tu mensaje", "h2", None, "accent", typography_typography="custom",
                typography_font_family="Nunito", typography_font_weight="800", typography_font_size=px(30),
                typography_font_size_mobile=px(26)),
        text("<p>Completa el formulario y te responderemos a la brevedad.</p>"),
        widget("wpforms", form_id=str(form_id), display_form_name="", display_form_description="",
               fieldSize="medium", fieldBorderRadius="12", fieldBorderColor="#DCE6F0", fieldTextColor="#243D5B",
               fieldBackgroundColor="#FFFFFF", labelColor="#243D5B", labelSublabelColor="#5B6C82",
               buttonSize="large", buttonBorderRadius="999", buttonBackgroundColor="#4A90E2",
               buttonBorderColor="#4A90E2", buttonTextColor="#FFFFFF", wpformsTheme="default"),
    ], width=54, width_t=100, g=14, padding=dims(36), padding_mobile=dims(24, 20), background_background="classic",
        border_border="solid", border_width=dims(1), border_radius=dims(24), box_shadow_box_shadow_type="yes",
        box_shadow_box_shadow=shadow(14, 36, 0.08), _title="Formulario",
        __globals__={"background_color": gc("blanco"), "border_color": gc("grisclaro")})
    return section([row([left, form], g=48, align="flex-start", stack="tablet", _title="Contacto")],
                   pad=(88, 120), anchor="contacto", title="Contacto")


# ---------------------------------------------------------------- páginas

def pages(form_id):
    return {
        "inicio": [hero(), products_section(), benefits_section(), how_to_buy_section(), testimonials_section(),
                   faq_section(FAQ[:3], more_link=True), cta_section()],
        "productos": [
            page_intro("Productos", "Nuestros productos esenciales",
                       "Tres básicos que resuelven muchas tareas de la casa. Te contamos para qué se usan y te "
                       "ayudamos a elegir el formato que te acomoda."),
            products_section(with_head=False), how_to_buy_section(), cta_section()],
        "beneficios": [
            page_intro("Beneficios", "¿Por qué elegir Karu Esencial?",
                       "Pocos productos, bien elegidos, para las tareas de todos los días."),
            benefits_section(with_head=False), how_to_buy_section(), testimonials_section(), cta_section()],
        "preguntas-frecuentes": [
            page_intro("Preguntas frecuentes", "Preguntas frecuentes",
                       "Respuestas breves sobre cómo comprar, precios, formatos y entregas."),
            faq_section(FAQ), cta_section()],
        "contacto": [
            page_intro("Contacto", "Conversemos",
                       "Escríbenos por WhatsApp o déjanos un mensaje. Te ayudamos a elegir y a coordinar tu pedido."),
            contact_section(form_id)],
    }


if __name__ == "__main__":
    import sys
    form_id = int(sys.argv[1]) if len(sys.argv) > 1 else 0
    out = Path(__file__).parent / "elementor"
    out.mkdir(exist_ok=True)
    for slug, data in pages(form_id).items():
        (out / f"{slug}.json").write_text(json.dumps(data, ensure_ascii=False, indent=1))
        print(slug, len(json.dumps(data)))
