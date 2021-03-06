YUI.add("moodle-qtype_ddlusher-dd", function(e, t) {
    var n = "ddlusher_dd", a = 0,

        r = function() { r.superclass.constructor.apply(this, arguments) };
    e.extend(r, e.Base, { doc: null, polltimer: null, afterimageloaddone: !1, poll_for_image_load: function(t, n, r, i) { if (this.afterimageloaddone) return; var s = this.doc.bg_img().get("complete");
            n && (s = s && this.doc.bg_img().hasClass("constrained")); var o = !this.doc.drag_item_homes().some(function(e) { if (e.get("tagName") !== "IMG") return !1; var t = e.get("complete"); return n && (t = t && e.hasClass("constrained")), !t }); if (s && o) this.polltimer !== null && (this.polltimer.cancel(), this.polltimer = null), this.doc.drag_item_homes().detach("load", this.poll_for_image_load), this.doc.bg_img().detach("load", this.poll_for_image_load), r !== 0 ? e.later(r, this, i) : i.call(this), this.afterimageloaddone = !0;
            else if (this.polltimer === null) { var u = [null, n, r, i];
                this.polltimer = e.later(1e3, this, this.poll_for_image_load, u, !0) } }, doc_structure: function(t) { var n = e.one(this.get("topnode")),
            r = n.one("div.dragitems"),
            i = n.one("div.droparea"); return { top_node: function() { return n }, drag_items: function() { return r.all(".drag") }, drop_zones: function() { return n.all("div.dropzones div.dropzone") }, drop_zone_group: function(e) { return n.all("div.dropzones div.group" + e) }, drag_items_cloned_from: function(e) { return r.all(".dragitems" + e) }, drag_item: function(e) { return r.one(".draginstance" + e) }, drag_items_in_group: function(e) { return r.all(".drag.group" + e) }, drag_item_homes: function() { return r.all(".draghome") }, bg_img: function() { return n.one(".dropbackground") }, load_bg_img: function(e) { i.setContent('<img class="dropbackground" src="' + e + '"/>'), this.bg_img().on("load", this.on_image_load, this, "bg_image") }, add_or_update_drag_item_home: function(e, t, n, i) { var s = this.drag_item_home(e),
                o = "draghome dragitemhomes" + e + " group" + i,
                u = '<img class="' + o + '" src="' + t + '" alt="' + n + '" />',
                a = '<div class="' + o + '">' + n + "</div>";
                s === null ? t ? r.append(u) : n !== "" && r.append(a) : (t ? r.insert(u, s) : n !== "" && r.insert(a, s), s.remove(!0)); var f = r.one(".dragitemhomes" + e);
                f !== null && (f.setData("groupno", i), f.setData("dragitemno", e)) }, drag_item_home: function(e) { return r.one(".dragitemhomes" + e) }, get_classname_numeric_suffix: function(e, t) { var n = e.getAttribute("class"); if (n !== "") { var r = n.split(" "); for (var i = 0; i < r.length; i++) { var s = new RegExp("^" + t + "([0-9])+$"); if (s.test(r[i])) { var o = new RegExp("([0-9])+$"),
                u = o.exec(r[i]); return +u[0] } } } throw 'Prefix "' + t + '" not found in class names.' }, clone_new_drag_item: function(e, t) { var n = this.drag_item_home(t); if (n === null) return null; var r = n.cloneNode(!0); return r.removeClass("dragitemhomes" + t), r.addClass("dragitems" + t), r.addClass("draginstance" + e), r.removeClass("draghome"), r.addClass("drag"), r.setStyles({ visibility: "visible", position: "absolute" }), r.setData("draginstanceno", e), r.setData("dragitemno", t), n.get("parentNode").appendChild(r), r }, draggable_for_question: function(t, r, i) {
                (new e.DD.Drag({ node: t, dragMode: "point", groups: [r] })).plug(e.Plugin.DDConstrained, { constrain2node: n }), t.setData("group", r), t.setData("choice", i) }, draggable_for_form: function(r) { var i = (new e.DD.Drag({ node: r, dragMode: "point" })).plug(e.Plugin.DDConstrained, { constrain2node: n });
                i.on("drag:end", function(e) { var n = e.target.get("node"),
                    r = n.getData("draginstanceno"),
                    i = n.getData("gooddrop");
                    i ? t.set_drag_xy(r, [e.pageX, e.pageY]) : t.reset_drag_xy(r) }, this), i.on("drag:start", function(e) { var t = e.target;
                    t.get("node").setData("gooddrop", !1) }, this) } } }, update_padding_sizes_all: function() { for (var e = 1; e <= 8; e++) this.update_padding_size_for_group(e) }, update_padding_size_for_group: function(e) { var t = this.doc.top_node().all(".draghome.group" + e); if (t.size() !== 0) { var n = 0,
            r = 0;
            t.each(function(e) { n = Math.max(n, e.get("clientWidth")), r = Math.max(r, e.get("clientHeight")) }, this), t.each(function(e) { var t = Math.round((10 + r - e.get("clientHeight")) / 2),
                i = Math.round((10 + n - e.get("clientWidth")) / 2);
                e.setStyle("padding", t + "px " + i + "px " + t + "px " + i + "px") }, this), this.doc.drop_zone_group(e).setStyles({ width: n + 10, height: r + 10 }) } }, convert_to_window_xy: function(e) { return [Number(e[0]) + this.doc.bg_img().getX() + 1, Number(e[1]) + this.doc.bg_img().getY() + 1] } }, { NAME: n, ATTRS: { drops: { value: null }, readonly: { value: !1 }, topnode: { value: null } } }), M.qtype_ddlusher = M.qtype_ddlusher || {}, M.qtype_ddlusher.dd_base_class = r;
    var i = "ddlusher_question",
        s = function() { s.superclass.constructor.apply(this, arguments) };
    e.extend(s, M.qtype_ddlusher.dd_base_class, {
        passiveSupported: !1,
        pendingid: "",
        initializer: function() { this.pendingid = "qtype_ddlusher-" + Math.random().toString(36).slice(2), M.util.js_pending(this.pendingid), this.doc = this.doc_structure(this), this.poll_for_image_load(null, !1, 10, this.create_all_drag_and_drops), this.doc.bg_img().after("load", this.poll_for_image_load, this, !1, 10, this.create_all_drag_and_drops), this.doc.drag_item_homes().after("load", this.poll_for_image_load, this, !1, 10, this.create_all_drag_and_drops), this.get("readonly") ? e.one("window").on("resize", function() { this.reposition_drags_for_question() }, this) : e.later(500, this, this.reposition_drags_for_question, !0), this.checkPassiveSupported() },
        prevent_touchmove_from_scrolling: function(t) { var n = e.UA.ie ? "MSPointerMove" : "touchmove",
            r = function(e) { e.preventDefault() },
            i = t.get("id"),
            s = document.getElementById(i);
            s.addEventListener(n, r, this.passiveSupported ? { passive: !1, capture: !0 } : !1) },
        checkPassiveSupported: function() { try { var e = Object.defineProperty({}, "passive", { get: function() { this.passiveSupported = !0 }.bind(this) });
            window.addEventListener("test", e, e), window.removeEventListener("test", e, e) } catch (t) { this.passiveSupported = !1 } },
        create_all_drag_and_drops: function() {
            this.init_drops(), this.update_padding_sizes_all();
            var e = 0;
            this.doc.drag_item_homes().each(function(t) {
                var n = Number(this.doc.get_classname_numeric_suffix(t, "dragitemhomes")),
                    r = +this.doc.get_classname_numeric_suffix(t, "choice"),
                    i = +this.doc.get_classname_numeric_suffix(t, "group"),
                    s = this.doc.drop_zone_group(i).size(),
                    o = this.doc.clone_new_drag_item(e, n);
                e++, this.get("readonly") || (this.doc.draggable_for_question(o, i, r), this.prevent_touchmove_from_scrolling(o));
                if (o.hasClass("infinite")) { var u = s - 1; while (u > 0) o = this.doc.clone_new_drag_item(e, n), e++, this.get("readonly") || (this.doc.draggable_for_question(o, i, r), this.prevent_touchmove_from_scrolling(o)), u-- }
            }, this), this.reposition_drags_for_question(), this.get("readonly") || (this.doc.drop_zones().set("tabIndex", 0), this.doc.drop_zones().each(function(e) { e.on("dragchange", this.drop_zone_key_press, this) }, this)), M.util.js_complete(this.pendingid)
        },
        drop_zone_key_press: function(e) { switch (e.direction) {
            case "next":
                this.place_next_drag_in(e.target); break;
            case "previous":
                this.place_previous_drag_in(e.target); break;
            case "remove":
                this.remove_drag_from_drop(e.target) }
            e.preventDefault(), this.reposition_drags_for_question() },
        place_next_drag_in: function(e) { this.search_for_unplaced_drop_choice(e, 1) },
        place_previous_drag_in: function(e) { this.search_for_unplaced_drop_choice(e, -1) },
        search_for_unplaced_drop_choice: function(e, t) { var n, r = this.current_drag_in_drop(e); if ("" === r)
            if (t === 1) n = 1;
            else { n = 1; var i = e.getData("group");
                this.doc.drag_items_in_group(i).each(function(e) { n = Math.max(n, e.getData("choice")) }, this) }
        else n = +r + t; var s;
            do { if (this.get_choices_for_drop(n, e).size() === 0) { this.remove_drag_from_drop(e); return }
                s = this.get_unplaced_choice_for_drop(n, e), n += t } while (s === null);
            this.place_drag_in_drop(s, e) },
        current_drag_in_drop: function(t) { var n = t.getData("inputid"),
            r = e.one("input#" + n); return r.get("value") },
        remove_drag_from_drop: function(e) { this.place_drag_in_drop(null, e) },
        place_drag_in_drop: function(t, n) { var r = n.getData("inputid"),
            i = e.one("input#" + r);  a = document.getElementById("countDrop").innerHTML;
            document.getElementById("countDrop").innerHTML =  parseInt(a) + parseInt(1);
            t !== null ? i.set("value", t.getData("choice")) : i.set("value", "") },
        reposition_drags_for_question: function(dotimeout) {
            this.doc.drag_items().removeClass('placed');
            var count = document.getElementById("countDrop");
            this.doc.drag_items().each(function(dragitem) {
                if (dragitem.dd !== undefined) {
                    dragitem.dd.detachAll('drag:start');
                }
            }, this);
            this.doc.drop_zones().each(function(dropzone) {
                var relativexy = dropzone.getData('xy');
                dropzone.setXY(this.convert_to_window_xy(relativexy));
                var inputcss = 'input#' + dropzone.getData('inputid');
                var input = this.doc.top_node().one(inputcss);
                var choice = input.get('value');
                if (choice !== "") {
                    var dragitem = this.get_unplaced_choice_for_drop(choice, dropzone);
                    if (dragitem !== null) {
                        dragitem.setXY(dropzone.getXY());
                        dragitem.addClass('placed');
                        if (dragitem.dd !== undefined) {
                            dragitem.dd.once('drag:start', function(e, input) {
                                input.set('value', '');
                                e.target.get('node').removeClass('placed');
                            }, this, input);
                            dropzone.setAttribute("hidden","true");
                        }
                    }
                }
            }, this);
            this.doc.drag_items().each(function(dragitem) {
                if (!dragitem.hasClass('placed') && !dragitem.hasClass('yui3-dd-dragging')) {
                    var dragitemhome = this.doc.drag_item_home(dragitem.getData('dragitemno'));
                    dragitem.setXY(dragitemhome.getXY());

                }
                if (dragitem.hasClass('placed')) {if(!this.get('readonly')) dragitem.setAttribute("hidden","true");}
            }, this);
            if (dotimeout) {
                Y.later(500, this, this.reposition_drags_for_question, true);
            }


        },
        get_choices_for_drop: function(e, t) { var n = t.getData("group"); return this.doc.top_node().all("div.dragitemgroup" + n + " .choice" + e + ".drag") },
        get_unplaced_choice_for_drop: function(e, t) { var n = this.get_choices_for_drop(e, t),
            r = null; return n.some(function(e) { return this.get("readonly") || !e.hasClass("placed") && !e.hasClass("yui3-dd-dragging") ? (r = e, !0) : !1 }), r },
        init_drops: function() { var t = this.doc.top_node().one("div.dropzones"),
            n = {}; for (var r = 1; r <= 8; r++) { var i = e.Node.create('<div class = "dropzonegroup' + r + '"></div>');
            t.append(i), n[r] = i } var s = function(e) { var t = e.drag.get("node"),
            n = e.drop.get("node");
            Number(n.getData("group")) === t.getData("group") && this.place_drag_in_drop(t, n) }; for (var o in this.get("drops")) { var u = this.get("drops")[o],
            a = "dropzone group" + u.group + " place" + o,
            f = u.text.replace('"', '"');
            f || (f = M.util.get_string("blank", "qtype_ddlusher")); var l = '<div title="' + f + '" class="' + a + '">' + '<span class="accesshide">' + f + "</span>&nbsp;</div>",
                c = e.Node.create(l);
            n[u.group].append(c), c.setStyles({ opacity: .5 }), c.setData("xy", u.xy), c.setData("place", o), c.setData("inputid", u.fieldname.replace(":", "_")), c.setData("group", u.group); var h = new e.DD.Drop({ node: c, groups: [u.group] });
            h.on("drop:hit", s, this) } }
    }, { NAME: i, ATTRS: {} }), e.Event.define("dragchange", { _event: e.UA.webkit || e.UA.ie ? "keydown" : "keypress", _keys: { 32: "next", 37: "previous", 38: "previous", 39: "next", 40: "next", 27: "remove" }, _keyHandler: function(e, t) { this._keys[e.keyCode] && (e.direction = this._keys[e.keyCode], t.fire(e)) }, on: function(e, t, n) { t._detacher = e.on(this._event, this._keyHandler, this, n) } }), M.qtype_ddlusher.init_question = function(e) { return new s(e) }
}, "@VERSION@", { requires: ["node", "dd", "dd-drop", "dd-constrain"] });