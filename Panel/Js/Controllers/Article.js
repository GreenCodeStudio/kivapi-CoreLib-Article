// import {FormManager} from "../../../Core/js/form";
// import {AjaxTask} from "../../../Core/js/ajaxTask";
// import {pageManager} from "../../../Core/js/pageManager";

import {DatasourceAjax} from "../../../../../../Core/Panel/Js/datasourceAjax";
import {ObjectsList} from "../../../../../../Core/Panel/Js/ObjectsList/objectsList";
import {FormManager} from "../../../../../../Core/Panel/Js/form";
import {PanelPageManager} from "../../../../../../Core/Panel/Js/PanelPageManager";
import {AjaxPanel} from "../../../../../../Core/Panel/Js/ajaxPanel";
import {Document, ParseXmlString} from "pmeditor-core"
import {Editor} from "pmeditor-editor"
import {t} from "../../i18n.xml"
import {t as TCommon} from "../../../../../../Core/Panel/Common/i18n.xml"
import ContentValueEdit from "../../../../../../Core/Panel/Page/Js/ValueEdit/ContentValueEdit";


export class index {
    constructor(page, data) {
        const container = page.querySelector('.list');
        let datasource = new DatasourceAjax('Article', 'getTable');
        let objectsList = new ObjectsList(datasource);
        objectsList.columns = [];
        objectsList.columns.push({
            name: t('Fields.id'),
            content: row => row.id,
            sortName: 'id',
            width: 180,
            widthGrow: 0
        });
        objectsList.columns.push({
            name: t('Fields.title'),
            content: row => row.title,
            sortName: 'title',
            width: 180,
            widthGrow: 1
        });


        //objectsList.sort = {"col": "stamp", "desc": true};
        objectsList.generateActions = (rows, mode) => {
            let ret = [];
            // if (rows.length == 1) {
            //     ret.push({
            //         name: TCommonBase("details"),
            //         icon: 'icon-show',
            //         href: "/Balance/show/" + rows[0].id,
            //         main: true
            //     });
            //if (Permissions.can('Balance', 'edit')) {
            ret.push({
                name: TCommon("Edit"),
                icon: 'icon-edit',
                href: "/panel/Article/edit/" + rows[0].id,
            });
            //}
            // }
            // if (mode != 'row' && Permissions.can('Balance', 'edit')) {
            //     ret.push({
            //         name: TCommonBase("openInNewTab"), icon: 'icon-show', showInTable: false, command() {
            //             rows.forEach(x => window.open("/Balance/show/" + x.id))
            //         }
            //     });
            // }
            return ret;
        }
        container.append(objectsList);
        objectsList.refresh();
    }
}

export class add {
    constructor(page, data) {
        this.page = page;
        this.data = data;

        let form = new FormManager(this.page.querySelector('form'));
        console.log('content')
       const contentEdit=new ContentValueEdit({}, {});
        contentEdit.draw();
        page.querySelector('.editor-container').append(contentEdit);

        form.submit = async data => {
            const content=contentEdit.collectParameters();
            data.content_type = content.value.mime;
            data.content = content.value.text;
            await AjaxPanel.Article.insert(data);
            PanelPageManager.goto('/panel/Article');
        }
    }
}

export class edit {
    constructor(page, data) {
        this.page = page;
        this.data = data;
        this.page.querySelectorAll('.print').forEach(x => x.onclick = () => print());

        let form = new FormManager(this.page.querySelector('form'));
        form.loadSelects(this.data.selects);

        let content;
        if (data.Article.content_type === 'text/pmeditor') {
            content = ParseXmlString(this.data.Article.content);
            const editor = new Editor(content);
            page.querySelector('.editor-container').append(editor.html);
            editor.render();
        } else {
            const textarea = page.querySelector('.editor-container').addChild('textarea', {name: 'content'});
        }

        form.load(this.data.Article);

        form.submit = async formData => {
            if (data.Article.content_type === 'text/pmeditor') {
                formData.content = content.serialize();
            }
            await AjaxPanel.Article.update(formData);
            PanelPageManager.goto('/panel/Article');
        }
    }
}
